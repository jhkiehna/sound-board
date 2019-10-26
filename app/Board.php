<?php

namespace App;

use App\User;
use App\SoundClip;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Board extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'layout'
    ];    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function soundClips()
    {
        return $this->belongsToMany(SoundClip::class, 'boards_sound_clips');
    }
}
