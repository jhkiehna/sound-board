<?php

namespace Tests\Feature;

use App\User;
use App\Board;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BoardTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanGetTheirBoards()
    {
        $board1 = factory(Board::class)->create();
        $board2 = factory(Board::class)->create([
            'user_id' => $board1->user
        ]);

        $response = $this->actingAs($board1->user)->json('GET', '/boards');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $board1->name,
            'name' => $board2->name,
            'user_id' => $board1->user->id
        ]);
    }

    public function testAUserCanGetASingleBoard()
    {
        $board = factory(Board::class)->create();

        $response = $this->actingAs($board->user)->json('GET', "/boards/{$board->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $board->name,
            'user_id' => $board->user->id
        ]);
    }

    public function testAUserCanCreateANewBoard()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/boards', [
          'name' => 'test board',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'test board'
        ]);
        $this->assertTrue($user->boards->first() != null);
    }

    public function testAUserCanUpdateABoardsName()
    {
        $board = factory(Board::class)->create();

        $response = $this->actingAs($board->user)->json('PATCH', "/boards/{$board->id}", [
            'name' => 'new test name'
        ]);

        $board->refresh();

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'new test name'
        ]);
        $this->assertEquals($board->name, 'new test name');
    }

    public function testAUserCanUpdateABoardsLayout()
    {
        $board = factory(Board::class)->create();
        $layout = json_encode(['version' => 1, 'field1' => 'test', 'field2' => 'test2']);

        $response = $this->actingAs($board->user)->json('PATCH', "/boards/{$board->id}", [
            'layout' => $layout
        ]);

        $board->refresh();

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => $board->name]);
        $response->assertJsonFragment(['layout' => $board->layout]);
        $this->assertEquals(json_decode($board->layout)->version, 1);
    }

    public function testAUserCanDeleteABoard()
    {
        $board = factory(Board::class)->create();
        $user = $board->user;

        $response = $this->actingAs($user)->json("DELETE", "/boards/{$board->id}");

        $response->assertStatus(204);
        $this->assertEmpty($user->boards()->get());
    }
}
