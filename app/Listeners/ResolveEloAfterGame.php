<?php

namespace App\Listeners;

use App\Events\GamePlayed;
use App\Services\EloService;

class ResolveEloAfterGame
{
    protected EloService $eloService;

    public function __construct(EloService $eloService)
    {
        $this->eloService = $eloService;
    }

    public function handle(GamePlayed $event): void
    {
        $this->eloService->resolveByGame($event->game);
    }
}
