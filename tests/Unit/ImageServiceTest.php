<?php

namespace Tests\Unit;

use App\Services\ImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    /** @test */
    public function can_fit_and_save_image()
    {
        Storage::fake();

        $imageService = new ImageService(
            new ImageManager()
        );

        $image = UploadedFile::fake()->createWithContent(
            'thumbnail.jpg',
            base64_decode(config('image.ladder.data'))
        );

        $filename = $imageService->fitAndSave($image);

        $this->assertEquals(
            config('image.ladder.filename'),
            $filename,
        );

        Storage::disk()->assertExists('images/' . $filename);
    }
}
