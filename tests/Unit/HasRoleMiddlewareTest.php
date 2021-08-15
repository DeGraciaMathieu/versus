<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class HasRoleMiddlewareTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware('has.role:admin')->get('/_tests/noway', function () {});
    }

    /** @test */
    public function admin_can_pass_middleware()
    {
        $admin = User::factory()->make([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/_tests/noway');
        $response->assertSuccessful();
    }

    /** @test */
    public function gamer_cant_pass_middleware()
    {
        $gamer = User::factory()->make([
            'role' => 'gamer',
        ]);

        $response = $this->actingAs($gamer)->get('/_tests/noway');
        $response->assertForbidden();
    }
}
