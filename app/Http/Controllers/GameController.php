<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Ladder;
use App\Events\GamePlayed;
use App\Http\Requests\StoreGame;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function create(Request $request, Ladder $ladder)
    {
        $user = $request->user();

        $teams = $ladder->teams()->with('users')->get();

        $ownTeams = $teams->filter(function ($team) use ($user) {
            return $team->users->contains($user);
        });

        $opponents = $teams->filter(function ($team) use ($user) {
            return ! $team->users->contains($user);
        });

        return view('game.create', ['ladder' => $ladder, 'ownTeams' => $ownTeams, 'opponents' => $opponents]);
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

        return redirect()->route('ladder.ranking', $ladder);
    }
}
