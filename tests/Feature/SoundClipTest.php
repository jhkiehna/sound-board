<?php

namespace Tests\Feature;

use App\User;
use App\Board;
use App\SoundClip;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SoundClipTest extends TestCase
{
    use RefreshDatabase;

    public function testAUserCanGetTheirSoundClips()
    {
        $soundClip1 = factory(SoundClip::class)->create();
        $soundClip2 = factory(SoundClip::class)->create([
            'user_id' => $soundClip1->user
        ]);

        $response = $this->actingAs($soundClip1->user)->json('GET', '/soundclips');

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $soundClip1->name,
            'name' => $soundClip2->name,
            'user_id' => $soundClip1->user->id
        ]);
    }

    public function testAUserCanGetASingleSoundClip()
    {
        $soundClip = factory(SoundClip::class)->create();

        $response = $this->actingAs($soundClip->user)->json('GET', "/soundclips/{$soundClip->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => $soundClip->name,
            'user_id' => $soundClip->user->id
        ]);
    }

    public function testAUserCanCreateANewSoundClip()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->json('POST', '/soundclips', [
          'name' => 'test sound clip',
        ]);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'test sound clip'
        ]);
        $this->assertTrue($user->soundClips->first() != null);
    }

    public function testAUserCanUpdateASoundClipsName()
    {
        $soundClip = factory(SoundClip::class)->create();

        $response = $this->actingAs($soundClip->user)->json('PATCH', "/soundclips/{$soundClip->id}", [
            'name' => 'new test name'
        ]);

        $soundClip->refresh();

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'new test name'
        ]);
        $this->assertEquals($soundClip->name, 'new test name');
    }

    public function testAUserCanDeleteASoundClip()
    {
        $soundClip = factory(SoundClip::class)->create();
        $user = $soundClip->user;

        $response = $this->actingAs($user)->json("DELETE", "/soundclips/{$soundClip->id}");

        $response->assertStatus(204);
        $this->assertEmpty($user->soundClips);
    }
}
