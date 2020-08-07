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
        // Passport::ignoreMigrations();
        // Passport::routes(null, ['middleware' => [
        //     // You can make this simpler by creating a tenancy route group
        //     InitializeTenancyBySubdomain::class,
        //     PreventAccessFromCentralDomains::class,
        // ]]);
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
