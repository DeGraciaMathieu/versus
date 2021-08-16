<?php

namespace App\Http\Middleware;

use App\Services\TeamService;
use Closure;
use Illuminate\Http\Request;

class TeamRegistred
{
    private TeamService $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->teamService->userCanRegisterGame($request->user(), $request->ladder)) {
            return $next($request);
        }

        return redirect()->route('team.create', $request->ladder);
    }
}
