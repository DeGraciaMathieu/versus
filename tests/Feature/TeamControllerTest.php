<?php

namespace Tests\Feature;

use App\Models\Ladder;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamControllerTest  extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function member_can_register_his_team()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);
        $ladder = Ladder::factory()->create();

        $response = $this->actingAs($member)->get('/ladders/' . $ladder->id . '/teams/create');
        $response->assertSuccessful();

        $response = $this->actingAs($member)->post('/ladders/' . $ladder->id . '/teams', [
            'name' => $name = 'YOLO team',
        ]);

        $response->assertRedirect('/ladders/' . $ladder->id . '/ranking');

        $this->assertDatabaseCount('teams', 1);
        $this->assertDatabaseHas('teams', [
            'name' => $name,
            'ladder_id' => $ladder->id,
        ]);

        $actualTeam = Team::where('name', $name)->first();

        $this->assertDatabaseHas('team_user', [
            'user_id' => $member->id,
            'team_id' => $actualTeam->id,
        ]);
    }

    /** @test */
    public function guest_cant_register_his_team()
    {
        $ladder = Ladder::factory()->create();

        $response = $this->get('/ladders/' . $ladder->id . '/teams/create');
        $response->assertRedirect('/login');

        $response = $this->post('/ladders/' . $ladder->id . '/teams', []);
        $response->assertRedirect('/login');
        $this->assertDatabaseCount('teams', 0);
    }
}
