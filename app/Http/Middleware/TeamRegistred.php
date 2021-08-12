<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamRegistred
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->userMissingRegistredTeam($request)) {
            return redirect()->route('team.create', $request->ladder);
        }

        return $next($request);
    }

    private function userMissingRegistredTeam(Request $request): bool
    {
        $ladderTeams = $request->ladder->teams()->select('id')->pluck('id')->toArray();

        return ! $request->user()->teams()->whereIn('teams.id', $ladderTeams)->exists();
    }
}
