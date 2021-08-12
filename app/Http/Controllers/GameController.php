<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Ladder;
use App\Events\GamePlayed;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreGame;
use Illuminate\Http\RedirectResponse;

class GameController extends Controller
{
    public function create(Ladder $ladder)
    {
        abort(500);
    }

    public function store(StoreGame $request, Ladder $ladder): RedirectResponse
    {
        $firstTeam = $ladder->teams->where('id', '=', $request->get('home_id'))->first();
        $secondTeam = $ladder->teams->where('id', '=', $request->get('away_id'))->first();

        $game = Game::create([
            'processed_at' => now(),
        ]);


        $game->teams()->save($firstTeam, ['score' => $request->get('home_score')]);
        $game->teams()->save($secondTeam, ['score' => $request->get('away_score')]);

        event(new GamePlayed($game));

        return redirect()->back();
    }
}
