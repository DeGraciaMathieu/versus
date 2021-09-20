<?php

namespace Tests\Feature;

use App\Models\Ladder;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_users()
    {
        $expectedUsers = User::factory()->count(2)->create();

        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/users');

        $response->assertSuccessful();
        $this->assertCount(3, $response['users']);
        $this->assertEquals($expectedUsers[0]->name, $response['users'][0]->name);
        $this->assertEquals($expectedUsers[1]->name, $response['users'][1]->name);
    }

    /** @test */
    public function member_cant_view_users()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $response = $this->actingAs($member)->get('/users');

        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_view_users()
    {
        $response = $this->get('/users');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function admin_can_edit_user()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'name' => 'Paul',
            'email' => 'old@example.com',
            'role' => 'member',
        ]);

        $response = $this->actingAs($admin)->get('/users/' . $user->id . '/edit');
        $response->assertSuccessful();

        $response = $this->actingAs($admin)->put('/users/' . $user->id, [
            'name' => $name = 'Martine',
            'email' => $email = "new@example.com",
            'role' => $role = 'admin',
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $name,
            'email' => $email,
            'role' => $role,
        ]);
    }

    /** @test */
    public function edit_user_affects_his_single_teams()
    {
        $admin = User::factory()->createQuietly([
            'role' => 'admin',
        ]);

        $user = User::factory()->createQuietly([
            'name' => 'Paul',
            'email' => 'old@example.com',
            'role' => 'member',
        ]);

        $singleLadder = Ladder::factory()->create([
            'mode' => 'single',
        ]);
        $userSingleTeam = Team::factory()->make([
            'name' => $userSingleTeamName = 'Paul',
        ]);
        $singleLadder->teams()->save($userSingleTeam);
        $user->teams()->save($userSingleTeam);

        $multiLadder = Ladder::factory()->create([
            'mode' => 'multi',
        ]);
        $userMultiTeam = Team::factory()->make([
            'name' => $userMultiTeamName = 'Dream Team',
        ]);
        $multiLadder->teams()->save($userMultiTeam);
        $user->teams()->save($userMultiTeam);

        $response = $this->actingAs($admin)->put('/users/' . $user->id, [
            'name' => $name = 'Martine',
        ]);

        $response->assertRedirect('/users');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $name,
        ]);

        $this->assertDatabaseHas('teams', [
            'name' => $userMultiTeamName,
        ]);

        $this->assertDatabaseMissing('teams', [
            'name' => $userSingleTeamName,
        ]);

        $this->assertDatabaseHas('teams', [
            'name' => $name,
        ]);
    }

    /** @test */
    public function member_cant_edit_user()
    {
        $member = User::factory()->create([
            'role' => 'member',
        ]);

        $user = User::factory()->create();

        $response = $this->actingAs($member)->put('/users/' . $user->id, [
            'name' => 'Not yet bro',
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function guest_cant_edit_ladder()
    {
        $user = User::factory()->create();

        $response = $this->put('/ladders/' . $user->id, [
            'name' => 'Not yet bro too',
        ]);

        $response->assertRedirect('/login');
    }
}
