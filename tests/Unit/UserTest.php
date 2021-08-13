<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_role()
    {
        $author = User::factory()->create(['role' => 'member']);

        $this->assertTrue($author->hasRole('member'));
    }

    /** @test */
    public function has_one_of_the_roles()
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->assertFalse($user->hasOneOfTheseRole(['admin']));
        $this->assertTrue($user->hasOneOfTheseRole(['user']));
        $this->assertTrue($user->hasOneOfTheseRole(['user', 'admin']));
    }
}
