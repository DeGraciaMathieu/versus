<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Ladder;
use App\Events\GamePlayed;
use App\Http\Requests\StoreGame;
use App\Models\Team;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('teams.ladder')
            ->orderByDesc('created_at')
            ->get();

        return view('game.index', ['games' => $games]);
    }

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

    public function destroy(Game $game)
    {
        $game->teams->each(function (Team $team) {
            $team->elo -= $team->pivot->elo_diff;

            $team->update();
        });

        $game->teams()->detach();

        $game->delete();

        return redirect()->route('game.index');
    }
}
