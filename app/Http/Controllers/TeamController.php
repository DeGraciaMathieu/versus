<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Ladder;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TeamController extends Controller
{
    private TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function create(Ladder $ladder)
    {
        return response()->view('team.create', ['ladder' => $ladder]);
    }

    public function store(Ladder $ladder, Request $request): RedirectResponse
    {
        $this->teamService->registerTeamForUser(
            $request->get('name'),
            $request->user(),
            $ladder
        );

        return redirect()->route('ladder.ranking', $ladder);
    }
}
