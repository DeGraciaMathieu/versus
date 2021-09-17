<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Models\Team;

class UpdateUserSingleTeams
{
    public function handle(UserSaved $event): void
    {
        $event->user->load('teams.ladder');

        $teams = $event->user->teams->filter(function(Team $team) {
            return $team->ladder->mode === 'single';
        });

        $teams->each(function(Team $team) use ($event) {
            $team->update([
                'name' => $event->user->name,
            ]);
        });
    }
}
