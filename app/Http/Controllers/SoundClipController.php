<?php

namespace App\Http\Controllers;

use App\SoundClip;
use Illuminate\Http\Request;
use App\Http\Requests\SoundClipRequest;
use App\Http\Resources\SoundClipResource;
use App\Http\Requests\SoundClipUploadRequest;
use App\Http\Resources\SoundClipResourceCollection;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileUnacceptableForCollection;

class SoundClipController extends Controller
{
    public function index(Request $request)
    {
        return new SoundClipResourceCollection($request->user()->soundClips);
    }

    public function store(SoundClipRequest $request)
    {
        $soundClip = SoundClip::make($request->all());
        $request->user()->soundClips()->save($soundClip);

        return new SoundClipResource($soundClip);
    }

    public function show(SoundClip $soundClip)
    {
        return new SoundClipResource($soundClip);
    }

    public function update(SoundClipRequest $request, SoundClip $soundClip)
    {
        $soundClip->update($request->all());

        return new SoundClipResource($soundClip->refresh());
    }

    public function destroy(SoundClip $soundClip)
    {
        $soundClip->delete();

        return response(null, 204);
    }

    public function upload(SoundClipUploadRequest $request, SoundClip $soundClip)
    {
        try {
            $soundClip->attachMedia($request->audioFile);
        } catch (FileUnacceptableForCollection $e) {
            return response()->json([
                'message' => 'Invalid file type'
            ], 422);
        }

        return (new SoundClipResource($soundClip->refresh()))
            ->response()
            ->setStatusCode(201);
    }
}
