<?php

namespace Tests\Unit;

use App\Board;
use App\SoundClip;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\FileUnacceptableForCollection;

class SoundClipTest extends TestCase
{
  use RefreshDatabase;

    public function testANewBoardCanBeCreated()
    {
        factory(SoundClip::class)->create();

        $soundClip = SoundClip::all()->first();

        $this->assertTrue($soundClip != null);
        $this->assertTrue($soundClip->user != null);
    }

    public function testABoardCanHaveASoundClip()
    {
        $board = factory(Board::class)->create();
        $soundClip = factory(SoundClip::class)->create([
            'user_id' => $board->user->id
        ]);
        $soundClip->boards()->save($board);

        $this->assertEquals($soundClip->boards()->first()->name, $board->name);
        $this->assertEquals($board->soundClips()->first()->name, $soundClip->name);
    }

    public function testASoundClipCanHaveAnAssociatedMediaFile()
    {
        Storage::fake('public');

        $filePath = __DIR__.'/../this_is_a_test.mp3';
        $soundClip = factory(SoundClip::class)->create();
        $mp3Base64 = base64_encode(file_get_contents($filePath));

        $soundClip->attachMedia($mp3Base64);
        $soundClip->refresh();

        $this->assertTrue($soundClip->getFirstMediaUrl('audio') != null);
        $this->assertTrue($soundClip->getFirstMedia('audio')->mime_type == 'audio/mpeg');
    }

    public function testASoundClipCantHaveWrongFileTypeAssociated()
    {
        $this->expectException(FileUnacceptableForCollection::class);

        Storage::fake('public');

        $filePath = __DIR__.'/../test-image.png';
        $soundClip = factory(SoundClip::class)->create();
        $mp3Base64 = base64_encode(file_get_contents($filePath));

        $soundClip->attachMedia($mp3Base64);
    }
}
