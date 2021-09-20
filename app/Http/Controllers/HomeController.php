<?php

namespace App\Http\Controllers;

use App\Services\ImageService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService =$imageService;
    }

    public function settings(Request $request)
    {
        $user = $request->user();

        return view('home.settings', ['user' => $user]);
    }

    public function updateSettings(Request $request)
    {
        $user = $request->user();

        if ($request->hasFile('photo')) {
            $filename = $this->imageService->fitAndSave(
                $request->file('photo')
            );

            $user->photo = $filename;
        }

        $user->update(
            $request->only(['name', 'email'])
        );

        return redirect()->route('home.settings');
    }
}
