<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLadderRequest;
use App\Http\Requests\UpdateLadderRequest;
use App\Models\Image;
use App\Models\Ladder;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LadderController extends Controller
{
    private ImageService $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService =$imageService;
    }

    public function index(): Response
    {
        $ladders = Ladder::withCount('teams')->get();

        return response()->view('ladder.index', ['ladders' => $ladders]);
    }

    public function ranking(Request $request, Ladder $ladder): Response
    {
        $teams = $ladder->teams()->whereNotNull('level')->orderBy('elo', 'desc')->get();

        $currentUserTeamId = null;

        if ($user = $request->user()) {
            $currentUserTeamId = optional($user->teams()->where('ladder_id', $ladder->id)->first())->id;
        }

        $rank = 1;

        $teams->each(function ($team) use (&$rank, $currentUserTeamId) {
            $team->rank = $rank++;
            $team->current = $team->id === $currentUserTeamId;
        });

        return response()->view('ladder.ranking', ['ladder' => $ladder, 'teams' => $teams]);
    }

    public function create()
    {
        return response()->view('ladder.create');
    }

    public function store(StoreLadderRequest $request): RedirectResponse
    {
        $filename = $this->imageService->fitAndSave(
            $request->file('thumbnail')
        );

        Ladder::create(
            $request->only(['name', 'description']) + ['thumbnail' => $filename]
        );

        return redirect()->route('ladder.index');
    }

    public function edit(Ladder $ladder)
    {
        return response()->view('ladder.edit', ['ladder' => $ladder]);
    }

    public function update(UpdateLadderRequest $request, Ladder $ladder): RedirectResponse
    {
        if ($request->hasFile('thumbnail')) {
            $filename = $this->imageService->fitAndSave(
                $request->file('thumbnail')
            );

            $ladder->thumbnail = $filename;
        }

        $ladder->update(
            $request->only(['name', 'description'])
        );

        return redirect()->route('ladder.index');
    }
}
