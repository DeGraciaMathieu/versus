<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Team;
use App\Models\Game;
use App\Models\Ladder;
use App\Services\EloService;
use App\Services\LevelService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EloServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function calculate_by_match_after_pro_win(): void
    {
        $ladder = Ladder::factory()->create();

        $noobTeam = Team::factory()->make([
            'elo' => 999,
        ]);

        $ladder->teams()->save($noobTeam);

        $proTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($proTeam);

        $game = Game::make([
            'processed_at' => now(),
        ]);

        $ladder->games()->save($game);

        $game->teams()->save($noobTeam, ['score' => 0]);
        $game->teams()->save($proTeam, ['score' => 11]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($game);

        $this->assertDatabaseHas('teams', [
            'id' => $noobTeam->id,
            'elo' => 999,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $proTeam->id,
            'elo' => 2200,
        ]);
    }

    /** @test */
    public function calculate_by_match_after_noob_win(): void
    {
        $ladder = Ladder::factory()->create();

        $noobTeam = Team::factory()->make([
            'elo' => 999,
        ]);

        $ladder->teams()->save($noobTeam);

        $proTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($proTeam);

        $game = Game::make([
            'processed_at' => now(),
        ]);

        $ladder->games()->save($game);

        $game->teams()->save($noobTeam, ['score' => 13]);
        $game->teams()->save($proTeam, ['score' => 11]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($game);

        $this->assertDatabaseHas('teams', [
            'id' => $noobTeam->id,
            'elo' => 1099,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $proTeam->id,
            'elo' => 2170,
        ]);
    }

    /** @test */
    public function calculate_by_match_after_new_challenger_win(): void
    {
        $ladder = Ladder::factory()->create();

        $newChallenger = Team::factory()->make();

        $ladder->teams()->save($newChallenger);

        $proTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($proTeam);

        $game = Game::make([
            'processed_at' => now(),
        ]);

        $ladder->games()->save($game);

        $game->teams()->save($newChallenger, ['score' => 13]);
        $game->teams()->save($proTeam, ['score' => 11]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($game);

        $this->assertDatabaseHas('teams', [
            'id' => $newChallenger->id,
            'elo' => 600,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $proTeam->id,
            'elo' => 2170,
        ]);
    }

    /** @test */
    public function calculate_by_match_after_draw(): void
    {
        $ladder = Ladder::factory()->create();

        $firstTeam = Team::factory()->make([
            'elo' => 999,
        ]);

        $ladder->teams()->save($firstTeam);

        $secondTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($secondTeam);

        $game = Game::make([
            'processed_at' => now(),
        ]);

        $ladder->games()->save($game);

        $game->teams()->save($firstTeam, ['score' => 9]);
        $game->teams()->save($secondTeam, ['score' => 9]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($game);

        $this->assertDatabaseHas('teams', [
            'id' => $firstTeam->id,
            'elo' => 1049,
        ]);

        $this->assertDatabaseHas('teams', [
            'id' => $secondTeam->id,
            'elo' => 2185,
        ]);
    }
}
