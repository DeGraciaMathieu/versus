<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Ladder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LadderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_ladders()
    {
        $expectedLadders = Ladder::factory()->count(2)->create();

        $response = $this->get('/');

        $response->assertSuccessful();
        $this->assertCount(2, $response['ladders']);
        $this->assertEquals($expectedLadders[0]->name, $response['ladders'][0]->name);
        $this->assertEquals($expectedLadders[1]->name, $response['ladders'][1]->name);
    }

    /** @test */
    public function member_can_view_ranking()
    {
        $ladder = Ladder::factory()->create();
        $member = User::factory()->create();

        list($memberTeam, $opponentTeam) = $this->makeSomeGamesForLadderAndMember($ladder, $member);

        $response = $this->actingAs($member)->get('/ladders/' . $ladder->id . '/ranking');

        $response->assertSuccessful();
        $this->assertEquals($ladder->name, $response['ladder']->name);

        $this->assertCount(2, $response['teams']);

        $this->assertEquals($memberTeam->name, $response['teams'][0]->name);
        $this->assertEquals(1, $response['teams'][0]->rank);
        $this->assertTrue($response['teams'][0]->current);

        $this->assertEquals($opponentTeam->name, $response['teams'][1]->name);
        $this->assertEquals(2, $response['teams'][1]->rank);
        $this->assertFalse($response['teams'][1]->current);
    }

    /** @test */
    public function admin_can_create_ladder()
    {
        Storage::fake();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/ladders/create');
        $response->assertSuccessful();

        $response = $this->actingAs($admin)->post('/ladders', [
            'name' => $name = '100v100 King',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
            'mode' => 'single',
            'thumbnail' => UploadedFile::fake()->createWithContent(
                'thumbnail.jpg',
                base64_decode(config('image.ladder.data'))
            ),
        ]);

        $thumbnail = config('image.ladder.filename');

        Storage::disk()->assertExists('images/' . $thumbnail);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('ladders', [
            'name' => $name,
            'thumbnail' => $thumbnail,
        ]);
    }

    /** @test */
    public function admin_cant_create_ladder_without_thumbnail()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->from('/ladders/create')->actingAs($admin)->post('/ladders', [
            'name' => '100v100 King',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertSessionHasErrors(['thumbnail']);
        $response->assertRedirect('/ladders/create');
    }

    /** @test */
    public function member_cant_create_ladder()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this->actingAs($member)->post('/ladders', [
            'name' => 'Not yet bro',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_create_ladder()
    {
        $response = $this->post('/ladders', [
            'name' => 'Not yet bro too',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_edit_ladder()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ladder = Ladder::factory()->create([
            'name' => 'From the past with love',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response = $this->actingAs($admin)->get('/ladders/' . $ladder->id . '/edit');
        $response->assertSuccessful();

        $response = $this->actingAs($admin)->put('/ladders/' . $ladder->id, [
            'name' => $name = 'New age !',
            'description' => "Everyday I'm Shuffling ...",
            'mode' => 'team',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('ladders', [
            'id' => $ladder->id,
            'name' => $name,
        ]);
    }

    /** @test */
    public function admin_can_edit_ladder_with_thumbnail()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $ladder = Ladder::factory()->create([
            'name' => 'From the past with love',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response = $this->actingAs($admin)->put('/ladders/' . $ladder->id, [
            'name' => $name = '100v100 King',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
            'mode' => 'single',
            'thumbnail' => UploadedFile::fake()->createWithContent(
                'thumbnail.jpg',
                base64_decode(config('image.ladder.data'))
            ),
        ]);

        $thumbnail = config('image.ladder.filename');

        Storage::disk()->assertExists('images/' . $thumbnail);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('ladders', [
            'id' => $ladder->id,
            'name' => $name,
            'thumbnail' => $thumbnail,
        ]);
    }

    /** @test */
    public function member_cant_edit_ladder()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $ladder = Ladder::factory()->create();

        $response = $this->actingAs($member)->put('/ladders/' . $ladder->id, [
            'name' => 'Not yet bro',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_edit_ladder()
    {
        $ladder = Ladder::factory()->create();

        $response = $this->put('/ladders/' . $ladder->id, [
            'name' => 'Not yet bro too',
        ]);

        $response->assertRedirect('/login');
    }
}
