<?php

namespace App\Providers;

use App\Models\Room;
use App\Models\Season;
use App\Models\SeasonalRoomCost;
use App\Observers\RoomObserver;
use App\Observers\SeasonObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Room::observe(RoomObserver::class);
        Season::observe(SeasonObserver::class);
    }
}
