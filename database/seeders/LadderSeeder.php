<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Ladder;
use App\Models\Team;
use App\Services\EloService;
use Illuminate\Database\Seeder;

class LadderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ladders = Ladder::factory(5)->create();

        $ladders->each(function (Ladder $ladder) {
            $ladder->teams()->saveMany($teams = Team::factory()->count($max = 4)->make());

            $teams = $teams->random($max);

            for ($i = 0; $i < 3; $i++) {
                $teams->each(function ($team) use ($teams, $max) {
                    $opponents = $teams->where('id', '!=', $team->id)->random($max - 1);

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
        });
    }
}
