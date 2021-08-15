<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show(string $filename): Response
    {
        $path = 'images/' . $filename;

        if (! Storage::exists($path)) {
            abort(404);
        }

        $image = Storage::get($path);

        $headers = [
            'Content-Type' => 'image/jpeg',
        ];

        return response($image, 200, $headers);
    }
}
