<?php

namespace App\Providers;

use Illuminate\Broadcasting\BroadcastServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Register any broadcast channels.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::channel('private-room_{roomId}', function () {
            return true;
        });
    }
}
