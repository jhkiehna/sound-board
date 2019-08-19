<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SoundClipResourceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($soundClip) {
            return [
                'id' => $soundClip->id,
                'user_id' => $soundClip->user_id,
                'name' => $soundClip->name,
                'created_at' => $soundClip->created_at,
                'updated_at' => $soundClip->updated_at,
                'url' => $soundClip->getFirstMediaUrl('audio')
            ];
        });
    }
}
