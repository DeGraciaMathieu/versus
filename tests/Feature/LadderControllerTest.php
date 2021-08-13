<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Team;
use App\Models\User;
use App\Models\Game;
use App\Models\Ladder;
use App\Services\EloService;
use App\Services\LevelService;
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

        $teams = $this->makeSomeGamesForLadderAndMember($ladder, $member);

        $response = $this->actingAs($member)->get('/ladders/' . $ladder->id . '/ranking');

        $response->assertSuccessful();
        $this->assertEquals($ladder->name, $response['ladder']->name);

        $this->assertCount(2, $response['teams']);

        $this->assertEquals($teams[0]->name, $response['teams'][0]->name);
        $this->assertEquals(1, $response['teams'][0]->rank);
        $this->assertTrue($response['teams'][0]->current);

        $this->assertEquals($teams[1]->name, $response['teams'][1]->name);
        $this->assertEquals(2, $response['teams'][1]->rank);
        $this->assertFalse($response['teams'][1]->current);
    }

    /** @test */
    public function admin_can_create_ladder()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/ladders/create');
        $response->assertSuccessful();

        $response = $this->actingAs($admin)->post('/ladders', [
            'name' => $name = '100v100 King',
            'description' => 'Lorem Elsass ipsum Salu bissame Spätzle ...',
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('ladders', [
            'name' => $name,
        ]);
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
        ]);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('ladders', [
            'id' => $ladder->id,
            'name' => $name,
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

    protected function makeSomeGamesForLadderAndMember(Ladder $ladder, User $member): array
    {
        $noobTeam = Team::factory()->make([
            'elo' => 999,
        ]);

        $ladder->teams()->save($noobTeam);

        $proTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($proTeam);
        $member->teams()->save($proTeam);

        $game = Game::create([
            'processed_at' => now(),
        ]);

        $game->teams()->save($noobTeam, ['score' => 0]);
        $game->teams()->save($proTeam, ['score' => 11]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($game);

        return [$proTeam, $noobTeam];
    }
}
