<?php

namespace Tests\Unit;

use App\Board;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SoundBoardTest extends TestCase
{
  use RefreshDatabase;

    public function testANewBoardCanBeCreated()
    {
        factory(Board::class)->create();

        $board = Board::all()->first();

        $this->assertTrue($board != null);
        $this->assertTrue($board->user != null);
    }
}
