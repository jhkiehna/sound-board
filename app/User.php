<?php

namespace App;

use App\Board;
use App\SoundClip;
use Webpatser\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    public function boards()
    {
        return $this->hasMany(Board::Class);
    }

    public function soundClips()
    {
        return $this->hasMany(SoundClip::Class);
    }

    public function signIn()
    {
        $this->api_token = $this->generateNewApiToken();
        $this->save(['touch' => false]);
    }

    public function signOut()
    {
        $this->api_token = null;
        $this->save(['touch' => false]);
    }

    public static function generateNewApiToken()
    {
        $firstTry = true;

        while($firstTry == true || self::where('api_token', $uuid)->first() != null) {
            $uuid = (string) Uuid::generate(4);
            $firstTry = false;
        }

        return $uuid;
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->api_token = self::generateNewApiToken();
        });
    }
}
