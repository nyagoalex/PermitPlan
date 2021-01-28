<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/gb', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });
});

Route::middleware([
    'api',
    InitializeTenancyBySubdomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::group(
        ['prefix' => 'auth'],
        function () {
            Route::post('token', 'Auth\LoginController@login')->name('auth.token');
            Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout')->middleware(['auth:api']);
            Route::get('me', 'Auth\LoginController@profile')->name('auth.profile')->middleware(['auth:api']);
        }
    );
    
    /**
     * all route that require user to be full authenticated
     */
    Route::group(
        ['middleware' =>  ['auth:api']],
        function () {
            Route::post('logo', 'SettingController@logo')->name('settings.logo');
            Route::get('settings', 'SettingController@index')->name('settings.get');
            Route::patch('settings', 'SettingController@update')->name('settings.update');
        
            Route::get('reports/permits-total', 'ReportController@permits')->name('reports.get');
            Route::group(
                ['prefix' => 'users'],
                function () {
                    Route::get('/', 'UserController@index')->name('users.all');
                    Route::get('/{userId}', 'UserController@show')->name('user.show');
                    Route::post('/', 'UserController@store')->name('user.create');
                    Route::patch('/{userId}', 'UserController@update')->name('user.update');
                    Route::delete('/{userId}', 'UserController@destroy')->name('user.delete');
                    Route::delete('/{userId}/deactivate', 'UserController@deactivateUser')->name('user.deactivate');
                    Route::post('/{userId}/activate', 'UserController@activateUser')->name('user.activate');
                    Route::post('/changepassword', 'UserController@changePassword')->name('user.changePassword');
                }
            );
    
            Route::group(
                ['prefix' => 'sectors'],
                function () {
                    Route::get('/', 'SectorController@index')->name('sector.all');
                    Route::get('/{sector_id}', 'SectorController@show')->name('sector.show');
                    Route::post('/', 'SectorController@store')->name('sector.create');
                    Route::patch('/{sector_id}', 'SectorController@update')->name('sector.update');
                    Route::delete('/{sector_id}', 'SectorController@destroy')->name('sector.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'permit-types'],
                function () {
                    Route::get('/', 'PermitTypeController@index')->name('permit_type.all');
                    Route::get('/{permit_type_name}', 'PermitTypeController@show')->name('permit_type.show');
                    Route::patch('/{permit_type_name}', 'PermitTypeController@update')->name('permit_type.update');
                }
            );
    
            Route::group(
                ['prefix' => 'agents'],
                function () {
                    Route::get('/', 'AgentController@index')->name('agent.all');
                    Route::get('/{agent_id}', 'AgentController@show')->name('agent.show');
                    Route::post('/', 'AgentController@store')->name('agent.create');
                    Route::patch('/{agent_id}', 'AgentController@update')->name('agent.update');
                    Route::delete('/{agent_id}', 'AgentController@destroy')->name('agent.delete');
                    Route::delete('/{agent_id}/deactivate', 'AgentController@deactivate')->name('agent.deactivate');
                    Route::post('/{agent_id}/activate', 'AgentController@activate')->name('agent.activate');
                }
            );
    
            Route::group(
                ['prefix' => 'guides'],
                function () {
                    Route::get('/', 'GuideController@index')->name('guide.all');
                    Route::get('/{guide_id}', 'GuideController@show')->name('guide.show');
                    Route::post('/', 'GuideController@store')->name('guide.create');
                    Route::patch('/{guide_id}', 'GuideController@update')->name('guide.update');
                    Route::delete('/{guide_id}', 'GuideController@destroy')->name('guide.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'vehicles'],
                function () {
                    Route::get('/', 'VehicleController@index')->name('vehicle.all');
                    Route::get('/{vehicle_id}', 'VehicleController@show')->name('vehicle.show');
                    Route::post('/', 'VehicleController@store')->name('vehicle.create');
                    Route::patch('/{vehicle_id}', 'VehicleController@update')->name('vehicle.update');
                    Route::delete('/{vehicle_id}', 'VehicleController@destroy')->name('vehicle.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'road-transfers'],
                function () {
                    Route::get('/', 'RoadTransferController@index')->name('road_transfer.all');
                    Route::get('/{road_transfer_id}', 'RoadTransferController@show')->name('road_transfer.show');
                    Route::post('/', 'RoadTransferController@store')->name('road_transfer.create');
                    Route::patch('/{road_transfer_id}', 'RoadTransferController@update')->name('road_transfer.update');
                    Route::delete('/{road_transfer_id}', 'RoadTransferController@destroy')->name('road_transfer.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'flight-transfers'],
                function () {
                    Route::get('/', 'FlightTransferController@index')->name('flight_transfer.all');
                    Route::get('/{flight_transfer_id}', 'FlightTransferController@show')->name('flight_transfer.show');
                    Route::post('/', 'FlightTransferController@store')->name('flight_transfer.create');
                    Route::patch('/{flight_transfer_id}', 'FlightTransferController@update')->name('flight_transfer.update');
                    Route::delete('/{flight_transfer_id}', 'FlightTransferController@destroy')->name('flight_transfer.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'activities'],
                function () {
                    Route::get('/', 'ActivityController@index')->name('activity.all');
                    Route::get('/{activity_id}', 'ActivityController@show')->name('activity.show');
                    Route::post('/', 'ActivityController@store')->name('activity.create');
                    Route::patch('/{activity_id}', 'ActivityController@update')->name('activity.update');
                    Route::delete('/{activity_id}', 'ActivityController@destroy')->name('activity.delete');
                }
            );

            Route::group(
                ['prefix' => 'lodges'],
                function () {
                    Route::get('/', 'LodgeController@index')->name('lodge.all');
                    Route::get('/{lodge_id}', 'LodgeController@show')->name('lodge.show');
                    Route::post('/', 'LodgeController@store')->name('lodge.create');
                    Route::patch('/{lodge_id}', 'LodgeController@update')->name('lodge.update');
                    Route::delete('/{lodge_id}', 'LodgeController@destroy')->name('lodge.delete');
                    Route::patch('/{lodge_id}/star-rating', 'LodgeController@updateStarRating')->name('lodge.starrating');
                    Route::patch('/{lodge_id}/contracted-rating', 'LodgeController@updateContractedRating')->name('lodge.contractedrating');
                }
            );

            Route::get('/lodge-seasonal-prices', 'LodgeController@lodgeSeasonalPrices')->name('lodge.seasonal.prices');
    
            Route::group(
                ['prefix' => 'lodges/{lodge_id}/rooms'],
                function () {
                    Route::get('/', 'Lodge\RoomController@index')->name('room.all');
                    Route::get('/{room_id}', 'Lodge\RoomController@show')->name('room.show');
                    Route::post('/', 'Lodge\RoomController@store')->name('room.create');
                    Route::patch('/{room_id}', 'Lodge\RoomController@update')->name('room.update');
                    Route::delete('/{room_id}', 'Lodge\RoomController@destroy')->name('room.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'lodges/{lodge_id}/activities'],
                function () {
                    Route::get('/', 'Lodge\LodgeActivityController@index')->name('activity.all');
                    Route::get('/{activity_id}', 'Lodge\LodgeActivityController@show')->name('activity.show');
                    Route::post('/', 'Lodge\LodgeActivityController@store')->name('activity.create');
                    Route::patch('/{activity_id}', 'Lodge\LodgeActivityController@update')->name('activity.update');
                    Route::delete('/{activity_id}', 'Lodge\LodgeActivityController@destroy')->name('activity.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'lodges/{lodge_id}/facilities'],
                function () {
                    Route::get('/', 'Lodge\LodgeFacilityController@index')->name('facility.all');
                    Route::get('/{facility_id}', 'Lodge\LodgeFacilityController@show')->name('facility.show');
                    Route::post('/', 'Lodge\LodgeFacilityController@store')->name('activity.create');
                    Route::patch('/{facility_id}', 'Lodge\LodgeFacilityController@update')->name('facility.update');
                    Route::delete('/{facility_id}', 'Lodge\LodgeFacilityController@destroy')->name('facility.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'lodges/{lodge_id}/seasons'],
                function () {
                    Route::get('/', 'Lodge\SeasonController@index')->name('season.all');
                    Route::get('/{season_id}', 'Lodge\SeasonController@show')->name('season.show');
                    Route::post('/', 'Lodge\SeasonController@store')->name('season.create');
                    Route::patch('/{season_id}', 'Lodge\SeasonController@update')->name('season.update');
                    Route::delete('/{season_id}', 'Lodge\SeasonController@destroy')->name('season.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'rooms/{room_id}/costs'],
                function () {
                    Route::get('/', 'Lodge\SeasonalRoomCostController@index')->name('cost.all');
                    Route::patch('/', 'Lodge\SeasonalRoomCostController@update')->name('cost.update');
                }
            );

            Route::group(
                ['prefix' => 'lodges/{lodge_id}/photos'],
                function () {
                    Route::get('/', 'Lodge\LodgePhotoController@index')->name('lodge.photos.all');
                    Route::post('/', 'Lodge\LodgePhotoController@store')->name('lodge.photos.create');
                    Route::patch('/{photo_id}', 'Lodge\LodgePhotoController@update')->name('lodge.photos.update');
                    Route::delete('/{photo_id}', 'Lodge\LodgePhotoController@destroy')->name('lodge.photos.delete');
                }
            );
    
            Route::group(
                ['prefix' => 'bookings'],
                function () {
                    Route::get('/', 'BookingController@index')->name('booking.all');
                    Route::get('/{booking_id}', 'BookingController@show')->name('booking.show');
                    Route::post('/', 'BookingController@store')->name('booking.create');
                    Route::patch('/{booking_id}', 'BookingController@update')->name('booking.update');
                    Route::delete('/{booking_id}', 'BookingController@destroy')->name('booking.delete');
                    Route::patch('/{booking_id}/comment', 'BookingController@comment')->name('booking.comment');
                    Route::post('/{booking_id}/confirm', 'BookingController@confirm')->name('booking.confirm');
                    Route::post('/{booking_id}/cancel', 'BookingController@cancel')->name('booking.cancel');
                    Route::get('/{booking_id}/notifications', 'BookingController@notifications')->name('booking.notifications');
                    Route::post('/{booking_id}/notifications/{id}/markasread', 'BookingController@markNotificationAsRead')->name('booking.notifications.markasread');
                    Route::post('/{booking_id}/notifications/markallasread', 'BookingController@markAllNotificationAsRead')->name('booking.notifications.markallasread');
                    Route::patch('/{booking_id}/itinerary', 'BookingController@updateItinerary')->name('booking.itinerary');
                    
                    Route::group(
                        ['prefix' => '{booking_id}/payments'],
                        function () {
                            Route::get('/', 'PaymentController@index')->name('booking.payment.all');
                            Route::post('/', 'PaymentController@store')->name('booking.payment.create');
                            Route::delete('/{payment_id}', 'PaymentController@destroy')->name('booking.payment.delete');
                        }
                    );
                    
                    Route::group(
                        ['prefix' => '{booking_id}/permits'],
                        function () {
                            Route::get('/', 'PermitController@index')->name('booking.permit.all');
                            Route::post('/', 'PermitController@store')->name('booking.permit.create');
                            Route::patch('/{permit_id}', 'PermitController@reshedule')->name('booking.permit.reshedule');
                            Route::delete('/{permit_id}', 'PermitController@destroy')->name('booking.permit.delete');
                            Route::post('/{permit_id}/transfer', 'PermitController@transfer')->name('booking.permit.transfer');
                        }
                    );
                    
                    Route::group(
                        ['prefix' => '{booking_id}/guests'],
                        function () {
                            Route::get('/', 'Booking\GuestController@index')->name('booking.guest.all');
                            Route::post('/', 'Booking\GuestController@store')->name('booking.guest.create');
                            Route::patch('/{guest_id}', 'Booking\GuestController@update')->name('booking.guest.update');
                            Route::delete('/{guest_id}', 'Booking\GuestController@destroy')->name('booking.guest.delete');
                        }
                    );
                    
                    Route::group(
                        ['prefix' => '{booking_id}/iteneraries'],
                        function () {
                            Route::get('/', 'Booking\BookingIteneraryController@index')->name('booking.itenerary.all');
                            Route::post('/', 'Booking\BookingIteneraryController@store')->name('booking.itenerary.create');
                            Route::patch('/{itenerary_id}', 'Booking\BookingIteneraryController@update')->name('booking.itenerary.update');
                            Route::delete('/{itenerary_id}', 'Booking\BookingIteneraryController@destroy')->name('booking.itenerary.delete');
                        }
                    );
                    
                    Route::group(
                        ['prefix' => '{booking_id}/accomodations'],
                        function () {
                            Route::get('/', 'Booking\BookingAccomodationController@index')->name('booking.accomodation.all');
                            Route::post('/', 'Booking\BookingAccomodationController@store')->name('booking.accomodation.create');
                            Route::patch('/{itenerary_id}', 'Booking\BookingAccomodationController@update')->name('booking.accomodation.update');
                            Route::delete('/{itenerary_id}', 'Booking\BookingAccomodationController@destroy')->name('booking.accomodation.delete');
                        }
                    );
                    
                    Route::group(
                        ['prefix' => '{booking_id}/activities'],
                        function () {
                            Route::get('/', 'Booking\BookingActivityController@index')->name('booking.activity.all');
                            Route::post('/', 'Booking\BookingActivityController@store')->name('booking.activity.create');
                            Route::patch('/{activity_id}', 'Booking\BookingActivityController@update')->name('booking.activity.update');
                            Route::delete('/{activity_id}', 'Booking\BookingActivityController@destroy')->name('booking.activity.delete');
                        }
                    );
                    
                    Route::group(
                        ['prefix' => '{booking_id}/guides'],
                        function () {
                            Route::get('/', 'Booking\BookingGuideController@index')->name('booking.guide.all');
                            Route::post('/', 'Booking\BookingGuideController@store')->name('booking.guide.create');
                            Route::patch('/{guide_id}', 'Booking\BookingGuideController@update')->name('booking.guide.update');
                            Route::delete('/{guide_id}', 'Booking\BookingGuideController@destroy')->name('booking.guide.delete');
                        }
                    );
                },
                # payments for items of booking
                Route::group(
                    ['prefix' => 'item-payments/{type_model}/{id}'],
                    function () {
                        Route::post('/', 'ItemPaymentController@store')->name('booking.item.payment.create');
                        Route::get('/', 'ItemPaymentController@index')->name('booking.item.payment.all');
                    }
                ),
                Route::delete('/item-payments/{payment_id}', 'ItemPaymentController@destroy')->name('booking.item.payment.delete'),
                  
                Route::group(
                    ['prefix' => 'departure-tours'],
                    function () {
                        Route::get('/', 'DepartureTourController@index')->name('departure.tour.all');
                        Route::get('/{tour_id}', 'DepartureTourController@show')->name('departure.tour.show');
                        Route::post('/', 'DepartureTourController@store')->name('departure.tour.create');
                        Route::patch('/{tour_id}', 'DepartureTourController@update')->name('departure.tour.update');
                        Route::delete('/{tour_id}', 'DepartureTourController@destroy')->name('departure.tour.delete');
                        Route::post('/{tour_id}/activate', 'DepartureTourController@activate')->name('departure.tour.activate');
                        Route::delete('/{tour_id}/deactivate', 'DepartureTourController@deactivate')->name('departure.tour.deactivate');

                        Route::group(
                            ['prefix' => '{tour_id}/permits'],
                            function () {
                                Route::get('/', 'DepartureTourPermitController@index')->name('departure.permit.all');
                                Route::post('/', 'DepartureTourPermitController@store')->name('departure.permit.create');
                                Route::delete('/{permit_id}', 'DepartureTourPermitController@destroy')->name('departure.permit.delete');
                                Route::post('/{permit_id}/allocate', 'DepartureTourPermitController@allocate')->name('departure.permit.allocate');
                                Route::patch('/{permit_id}', 'DepartureTourPermitController@reshedule')->name('departure.permit.update');
                            }
                        );
                    }
                )
            );
            Route::group(
                ['prefix' => 'itineraries'],
                function () {
                    Route::get('/', 'ItineraryController@index')->name('itinerary.all');
                    Route::get('/{itinerary_id}', 'ItineraryController@show')->name('itinerary.show');
                    Route::post('/', 'ItineraryController@store')->name('itinerary.create');
                    Route::patch('/{itinerary_id}', 'ItineraryController@update')->name('itinerary.update');
                    Route::delete('/{itinerary_id}', 'ItineraryController@destroy')->name('itinerary.delete');
                    Route::get('/{itinerary_id}/preview', 'ItineraryController@preview')->name('itinerary.preview');
                    Route::delete('/{itinerary_id}/deactivate', 'ItineraryController@deactivate')->name('itinerary.deactivate');
                    Route::post('/{itinerary_id}/activate', 'ItineraryController@activate')->name('itinerary.activate');
                }
            );
        }
    );
});
