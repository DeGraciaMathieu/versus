<?php

namespace App\Http\Controllers;

use App\Models\Ladder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LadderController extends Controller
{
    public function index(): Response
    {
        $ladders = Ladder::all();

        return response()->view('ladder.index', ['ladders' => $ladders]);
    }

    public function ranking(Request $request, Ladder $ladder): Response
    {
        $teams = $ladder->teams()->whereNotNull('level')->orderBy('elo', 'desc')->get();

        $currentUserTeamId = null;

        if ($user = $request->user()) {
            $currentUserTeamId = optional($user->teams()->where('ladder_id', $ladder->id)->first())->id;
        }

        $rank = 1;

        $teams->each(function ($team) use (&$rank, $currentUserTeamId) {
            $team->rank = $rank++;
            $team->current = $team->id === $currentUserTeamId;
        });

        return response()->view('ladder.ranking', ['ladder' => $ladder, 'teams' => $teams]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        Ladder::create(
            $request->only(['name', 'description'])
        );

        return redirect()->route('ladder.index');
    }

    public function update(Request $request, Ladder $ladder): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $ladder->update(
            $request->only(['name', 'description'])
        );

        return redirect()->route('ladder.index');
    }
}
