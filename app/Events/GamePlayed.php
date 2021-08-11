<?php

namespace App\Events;

use App\Models\Game;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;

class GamePlayed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Game $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
    }
}
