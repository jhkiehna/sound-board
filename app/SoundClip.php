<?php

namespace App;

use App\User;
use App\Board;
use Spatie\MediaLibrary\File;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SoundClip extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    protected $fillable = [
        'name'
    ];

    protected $acceptableMimeTypes = [
        'audio/mpeg',
        'audio/mpeg3',
        'audio/x-mpeg-3',
        'audio/wav',
        'audio/x-wav',
        'audio/aiff',
        'audio/x-aiff'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function boards()
    {
        return $this->belongsToMany(Board::class, 'boards_sound_clips');
    }

    public function attachMedia($base64)
    {
        $this->addMediaFromBase64($base64)->toMediaCollection();
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('audio')
            ->singleFile()
            ->acceptsFile(function (File $file) {
                $acceptableMimeTypes = collect($this->acceptableMimeTypes);

                return $acceptableMimeTypes->contains($file->mimeType);
            });
    }
}
