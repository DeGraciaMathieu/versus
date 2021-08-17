<?php

namespace Tests;

use App\Models\Game;
use App\Models\Ladder;
use App\Models\Team;
use App\Models\User;
use App\Services\EloService;
use App\Services\LevelService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function makeSomeGamesForLadderAndMember(Ladder $ladder, User $member): array
    {
        $opponentTeam = Team::factory()->make([
            'elo' => 999,
        ]);

        $ladder->teams()->save($opponentTeam);

        $memberTeam = Team::factory()->make([
            'elo' => 2200,
        ]);

        $ladder->teams()->save($memberTeam);
        $member->teams()->save($memberTeam);

        $this->makeAGame($ladder, $memberTeam, $opponentTeam);

        return [$memberTeam, $opponentTeam];
    }

    protected function makeAGame(Ladder $ladder, Team $winner, Team $looser)
    {
        $game = Game::make([
            'processed_at' => now(),
        ]);

        $ladder->games()->save($game);

        $game->teams()->save($winner, ['score' => 1]);
        $game->teams()->save($looser, ['score' => 0]);

        $eloService = new EloService(new LevelService($this->app->get('config')));

        $eloService->resolveByGame($game);

        return $game;
    }
}
