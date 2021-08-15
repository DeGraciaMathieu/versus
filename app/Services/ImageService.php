<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;

class ImageService
{
    /**
     * @var \Intervention\Image\ImageManager
     */
    private ImageManager $imageManager;

    public function __construct(ImageManager $imageManager)
    {
        $this->imageManager = $imageManager;
    }

    public function fitAndSave(UploadedFile $file): string
    {
        // @todo fit & convert image to jpg

        $filename = $this->generateFilename($file);

        $file->storeAs('images', $filename);

        return $filename;
    }

    protected function generateFilename(UploadedFile $file): string
    {
        return sha1($file->getContent());
    }
}
