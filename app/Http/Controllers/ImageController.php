<?php

namespace App\Http\Controllers;

use App\Exceptions\UnexpectedImageDataException;
use App\Models\Image;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    public function show(Image $image): Response
    {
        try {
            $headers = [
                'Content-Type' => $image->getType(),
            ];

            return response(base64_decode($image->data), 200, $headers);
        } catch (UnexpectedImageDataException $e) {
            abort(500);
        }
    }
}
