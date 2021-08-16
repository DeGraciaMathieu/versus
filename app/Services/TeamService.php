<?php

namespace App\Services;

use App\Models\Ladder;
use App\Models\Team;
use App\Models\User;

class TeamService
{
    public function userCanRegisterGame(User $user, Ladder $ladder): bool
    {
        if ($this->userHasRegistredTeam($user, $ladder)) {
            return true;
        }

        if ($ladder->hasSingleMode()) {
            $this->registerTeamForUser($user->name, $user, $ladder);

            return true;
        }

        return false;
    }

    public function registerTeamForUser(string $teamName, User $user, Ladder $ladder)
    {
        $team = Team::make(['name' => $teamName]);

        $ladder->teams()->save($team);
        $user->teams()->attach($team);
    }

    private function userHasRegistredTeam(User $user, Ladder $ladder): bool
    {
        $ladderTeams = $ladder->teams()->select('id')->pluck('id')->toArray();

        return $user->teams()->whereIn('teams.id', $ladderTeams)->exists();
    }
}
