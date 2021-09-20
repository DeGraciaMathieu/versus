<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function is_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($admin->isAdmin());

        $member = User::factory()->create(['role' => 'member']);

        $this->assertFalse($member->isAdmin());
    }

    /** @test */
    public function get_custom_photo()
    {
        $user = User::factory()->create(['photo' => 'my-custom-photo']);

        $this->assertEquals('my-custom-photo', $user->getPhoto());
    }

    /** @test */
    public function get_default_photo()
    {
        $user = User::factory()->create(['photo' => null]);

        $this->assertEquals(User::DEFAULT_PHOTO, $user->getPhoto());
    }
}
