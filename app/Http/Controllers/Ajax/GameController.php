<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Game;
use App\Models\Ladder;
use App\Events\GamePlayed;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreGame;
use App\Http\Controllers\Controller;

class GameController extends Controller
{
    public function store(StoreGame $request, Ladder $ladder): JsonResponse
    {
        $firstTeam = $ladder->teams->where('id', '=', $request->get('home_id'))->first();
        $secondTeam = $ladder->teams->where('id', '=', $request->get('away_id'))->first();

        $game = Game::create([
            'processed_at' => now(),
        ]);

        $game->teams()->save($firstTeam, ['score' => $request->get('home_score')]);
        $game->teams()->save($secondTeam, ['score' => $request->get('away_score')]);

        event(new GamePlayed($game));

        return response()->json(['message' => __('messages.game.added')]);
    }
}
