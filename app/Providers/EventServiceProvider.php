<?php

namespace App\Providers;

use App\Events\GamePlayed;
use App\Events\UserSaved;
use App\Listeners\UpdateUserSingleTeams;
use Illuminate\Auth\Events\Registered;
use App\Listeners\ResolveEloAfterGame;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        GamePlayed::class => [
            ResolveEloAfterGame::class,
        ],
        UserSaved::class => [
            UpdateUserSingleTeams::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
