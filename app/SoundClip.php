<?php

namespace App;

use App\User;
use App\Board;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SoundClip extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class, 'boards_sound_clips');
    }
}
