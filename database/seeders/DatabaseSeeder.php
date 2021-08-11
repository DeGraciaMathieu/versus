<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use App\Models\Game;
use App\Models\Ladder;
use App\Services\EloService;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $ladder = Ladder::factory()->create([
            'name' => '1v1 Pong',
        ]);

        $ladder->teams()->saveMany($teams = Team::factory()->count(16)->make());

        $teams = $teams->random(12);

        for ($i = 0; $i < 3; $i++) {
            $teams->each(function ($team) use ($teams) {
                $opponents = $teams->where('id', '!=', $team->id)->random(5);

                $opponents->each(function ($opponent) use ($team) {
                    $game = Game::create([
                        'processed_at' => now(),
                    ]);

                    $teamScore = 11;
                    $opponentScore = rand(0, 9);

                    $game->teams()->save($team, ['score' => $teamScore]);
                    $game->teams()->save($opponent, ['score' => $opponentScore]);

                    $this->container->get(EloService::class)->resolveByGame($game);
                });
            });
        }
    }
}
