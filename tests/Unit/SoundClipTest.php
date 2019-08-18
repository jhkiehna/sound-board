<?php

namespace Tests\Unit;

use App\Board;
use App\SoundClip;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
}
