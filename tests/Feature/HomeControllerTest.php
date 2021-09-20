<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_edit_self_settings()
    {
        $user = User::factory()->create([
            'name' => 'Roberto',
            'email' => 'old@example.com',
        ]);

        $response = $this->actingAs($user)->get('/home/settings');
        $response->assertSuccessful();

        $response = $this->actingAs($user)->put('/home/settings', [
            'name' => $name = 'Martine',
            'email' => $email = "new@example.com",
        ]);

        $response->assertRedirect('/home/settings');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $name,
            'email' => $email,
        ]);
    }

    /** @test */
    public function user_can_edit_his_role()
    {
        $user = User::factory()->create([
            'role' => $role = 'member'
        ]);

        $response = $this->actingAs($user)->put('/home/settings', [
            'role' => 'hacker',
        ]);

        $response->assertRedirect('/home/settings');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'role' => $role,
        ]);
    }
}
