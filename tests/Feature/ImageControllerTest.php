<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Ladder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_show_image()
    {
        $ladder = Ladder::factory()->create();

        $image = $ladder->thumbnail;

        $response = $this->get('/images/' . $image->id);

        $response->assertSuccessful();
        $response->assertHeader('Content-Type', 'image/jpeg');
    }

    /** @test */
    public function guest_cant_show_not_found_image()
    {
        $response = $this->get('/images/' . 'no-way');

        $response->assertNotFound();
    }
}
