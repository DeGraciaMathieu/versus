<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Ladder;
use App\Models\Team;
use App\Services\EloService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LadderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ladders = Ladder::factory(3)->create();

        $ladders->each(function (Ladder $ladder) {
            $ladder->teams()->saveMany($teams = Team::factory()->count($max = 5)->make());

            $teams = $teams->random($max);

            for ($i = 0; $i < 3; $i++) {
                $teams->each(function ($team) use ($teams, $ladder, $max) {
                    $opponents = $teams->where('id', '!=', $team->id)->random($max - 1);

                    $opponents->each(function ($opponent) use ($team, $ladder) {
                        $game = Game::factory()->make();

                        $ladder->games()->save($game);

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
