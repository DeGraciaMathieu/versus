<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Team;
use App\Models\Ladder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AjaxGameControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_store_game()
    {
        $ladder = Ladder::factory()->create();

        $ladder->teams()->saveMany(
            $teams = Team::factory()->count(2)->make()
        );

        $response = $this->post('/ajax/ladders/' . $ladder->id . '/games', [
            'home_id' => $teams->first()->id,
            'away_id' => $teams->last()->id,
            'home_score' => 3,
            'away_score' => 0,
        ]);

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

        $response->assertSuccessful();
    }
}
