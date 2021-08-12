<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Ladder;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    public function create(Ladder $ladder)
    {
        return response()->view('team.create', ['ladder' => $ladder]);
    }

    public function store(Ladder $ladder, Request $request): RedirectResponse
    {
        $team = Team::make($request->only('name'));

        $ladder->teams()->save($team);

        return redirect()->route('ladder.ranking', $ladder);
    }
}
