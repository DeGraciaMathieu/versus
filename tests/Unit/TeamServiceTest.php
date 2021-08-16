<?php

namespace Tests\Unit;

use App\Models\Ladder;
use App\Models\Team;
use App\Models\User;
use App\Services\TeamService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register_team_for_user()
    {
        $teamName = 'Squadra Azura';
        $ladder = Ladder::factory()->create();
        $member = User::factory()->create();

        $teamService = new TeamService();

        $teamService->registerTeamForUser($teamName, $member, $ladder);

        $this->assertDatabaseHas('teams', [
            'name' => $teamName,
            'ladder_id' => $ladder->id,
        ]);

        $team = Team::where('name', $teamName)->first();

        $this->assertDatabaseHas('team_user', [
            'team_id' => $team->id,
            'user_id' => $member->id,
        ]);
    }

    /** @test */
    public function user_granted_to_register_a_game_because_single_mode()
    {
        $ladderHasSingleMode = Ladder::factory()->create([
            'mode' => 'single',
        ]);

        $memberWithoutTeam = User::factory()->create();

        $teamService = new TeamService();

        $this->assertTrue(
            $teamService->userCanRegisterGame($memberWithoutTeam, $ladderHasSingleMode)
        );

        $this->assertDatabaseHas('teams', [
            'name' => $memberWithoutTeam->name,
            'ladder_id' => $ladderHasSingleMode->id,
        ]);

        $team = Team::where('name', $memberWithoutTeam->name)->first();

        $this->assertDatabaseHas('team_user', [
            'team_id' => $team->id,
            'user_id' => $memberWithoutTeam->id,
        ]);
    }

    /** @test */
    public function user_granted_to_register_a_game_because_has_team()
    {
        $ladder = Ladder::factory()->create([
            'mode' => 'team',
        ]);
        $ladder->teams()->save(
            $team = Team::factory()->make()
        );
        $member = User::factory()->create();
        $member->teams()->attach($team);

        $teamService = new TeamService();

        $this->assertTrue(
            $teamService->userCanRegisterGame($member, $ladder)
        );
    }

    /** @test */
    public function user_not_granted_to_register_a_game()
    {
        $ladder = Ladder::factory()->create([
            'mode' => 'team',
        ]);
        $member = User::factory()->create();

        $teamService = new TeamService();

        $this->assertFalse(
            $teamService->userCanRegisterGame($member, $ladder)
        );
    }
}
