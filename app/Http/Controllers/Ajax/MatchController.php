<?php

namespace App\Http\Controllers\Ajax;

use App\Models\Game;
use App\Models\Ladder;
use App\Events\GamePlayed;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreMatch;
use App\Http\Controllers\Controller;

class MatchController extends Controller
{
    public function store(StoreMatch $request, Ladder $ladder): JsonResponse
    {
        $firstTeam = $ladder->teams->where('id', '=', $request->get('home_id'))->first();
        $secondTeam = $ladder->teams->where('id', '=', $request->get('away_id'))->first();

        $match = Game::create([
            'processed_at' => now(),
        ]);

        $match->teams()->save($firstTeam, ['score' => $request->get('home_score')]);
        $match->teams()->save($secondTeam, ['score' => $request->get('away_score')]);

        event(new GamePlayed($match));

        return response()->json(['message' => __('messages.match.added')]);
    }
}
