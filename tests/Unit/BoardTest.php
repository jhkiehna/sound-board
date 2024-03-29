<?php

namespace Tests\Unit;

use App\Board;
use App\SoundClip;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardTest extends TestCase
{
  use RefreshDatabase;

    public function testANewBoardCanBeCreated()
    {
        factory(Board::class)->create();

        $board = Board::all()->first();

        $this->assertTrue($board != null);
        $this->assertTrue($board->user != null);
    }

    public function testABoardCanBeUpdatedWithALayout()
    {
        $board = factory(Board::class)->create();
        $board->update([
          'layout' => json_encode(['version' => 1, 'field1' => 'test', 'field2' => 'test2'])
        ]);
        $board->refresh();

        $this->assertTrue($board->layout != null);
        $this->assertTrue(json_decode($board->layout)->version == 1);
    }

    public function testABoardCanHaveASoundClip()
    {
      $soundClip = factory(SoundClip::class)->create();
      $board = factory(Board::class)->create([
        'user_id' => $soundClip->user->id
      ]);
      $board->soundClips()->save($soundClip);

      $this->assertEquals($board->soundClips()->first()->name, $soundClip->name);
      $this->assertEquals($soundClip->boards()->first()->name, $board->name);
    }
}
