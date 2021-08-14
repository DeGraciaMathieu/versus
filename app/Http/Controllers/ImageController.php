<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function show(string $filename): Response
    {
        $image = Storage::get('images/' . $filename);

        $headers = [
            'Content-Type' => 'image/jpeg',
        ];

        return response($image, 200, $headers);
    }
}
