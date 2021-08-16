<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use App\Models\Team;
use App\Models\Ladder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function member_can_store_game()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);
        $ladder = Ladder::factory()->create();
        $ladder->teams()->saveMany(
            $teams = Team::factory()->count(2)->make()
        );
        $member->teams()->attach($teams->first());

        $response = $this->actingAs($member)->get('/ladders/' . $ladder->id . '/games/create');
        $response->assertSuccessful();
        $this->assertEquals($teams[0]->name, $response['ownTeams'][0]->name);
        $this->assertEquals($teams[1]->name, $response['opponents'][1]->name);

        $response = $this->actingAs($member)->post('/ladders/' . $ladder->id . '/games', [
            'home_id' => $teams->first()->id,
            'away_id' => $teams->last()->id,
            'home_score' => 3,
            'away_score' => 0,
        ]);

        $response->assertRedirect('/ladders/' . $ladder->id . '/ranking');

        $this->assertDatabaseCount('games', 1);
        $this->assertDatabaseHas('game_team', [
            'team_id' => $teams->first()->id,
            'score' => 3,
            'won' => true,
        ]);
        $this->assertDatabaseHas('game_team', [
            'team_id' => $teams->last()->id,
            'score' => 0,
            'won' => false,
        ]);
    }

    /** @test */
    public function member_without_team_can_register_game_in_ladder_with_single_mode()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);
        $ladder = Ladder::factory()->create([
            'mode' => 'single',
        ]);

        $response = $this->actingAs($member)->get('/ladders/' . $ladder->id . '/games/create');
        $response->assertSuccessful();

        $this->assertDatabaseHas('teams', [
            'name' => $member->name,
            'ladder_id' => $ladder->id,
        ]);
    }

    /** @test */
    public function member_without_team_cant_register_game_in_ladder_without_single_mode()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);
        $ladder = Ladder::factory()->create([
            'mode' => 'team',
        ]);

        $response = $this->actingAs($member)->get('/ladders/' . $ladder->id . '/games/create');
        $response->assertRedirect('/ladders/' . $ladder->id . '/teams/create');

        $response = $this->actingAs($member)->post('/ladders/' . $ladder->id . '/games', []);
        $response->assertRedirect('/ladders/' . $ladder->id . '/teams/create');
        $this->assertDatabaseCount('games', 0);
    }

    /** @test */
    public function guest_cant_register_game()
    {
        $ladder = Ladder::factory()->create();

        $response = $this->get('/ladders/' . $ladder->id . '/games/create');
        $response->assertRedirect('/login');

        $response = $this->post('/ladders/' . $ladder->id . '/games', []);
        $response->assertRedirect('/login');
        $this->assertDatabaseCount('games', 0);
    }

    /** @test */
    public function admin_can_list_games()
    {
        $ladder = Ladder::factory()->create();
        $ladder->teams()->saveMany(
            list($winner, $looser) = Team::factory(2)->make([
                'elo' => 500,
            ])
        );

        $this->makeAGame($winner, $looser);

        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get('/games');
        $response->assertSuccessful();
        $this->assertCount(1, $response['games']);
    }

    /** @test */
    public function member_cant_list_games()
    {
        $member = User::factory()->create();

        $response = $this->actingAs($member)->get('/games');
        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_list_games()
    {
        $response = $this->get('/games');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_delete_game()
    {
        $ladder = Ladder::factory()->create();
        $ladder->teams()->saveMany(
            list($winner, $looser) = Team::factory(2)->make([
                'elo' => 500,
            ])
        );

        $game = $this->makeAGame($winner, $looser);

        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->delete('/games/' . $game->id);
        $response->assertRedirect('/games');

        $this->assertDatabaseMissing('games', [
            'id' => $game->id,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $winner->id,
            'elo' => 500,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $looser->id,
            'elo' => 500,
        ]);
    }

    /** @test */
    public function member_cant_delete_game()
    {
        $ladder = Ladder::factory()->create();
        $ladder->teams()->saveMany(
            list($winner, $looser) = Team::factory(2)->make([
                'elo' => 500,
            ])
        );

        $game = $this->makeAGame($winner, $looser);
        $member = User::factory()->create();

        $response = $this->actingAs($member)->delete('/games/' . $game->id);
        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_delete_game()
    {
        $ladder = Ladder::factory()->create();
        $ladder->teams()->saveMany(
            list($winner, $looser) = Team::factory(2)->make([
                'elo' => 500,
            ])
        );

        $game = $this->makeAGame($winner, $looser);

        $response = $this->delete('/games/' . $game->id);
        $response->assertRedirect('/login');
    }
}
