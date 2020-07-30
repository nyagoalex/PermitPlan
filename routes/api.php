<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(
    ['prefix' => 'auth'],
    function () {
        Route::post('token', 'Auth\LoginController@login')->name('auth.token');
        Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout')->middleware(['auth:api']);
        // Route::get('me', 'AuthController@profile')->name('auth.profile')->middleware(['auth:api']);
    }
);

/**
 * all route that require user to be full authenticated
 */
Route::group(
    ['middleware' =>  ['auth:api']],
    function () {
        Route::get('settings', 'SettingController@index')->name('settings.get');
        Route::patch('settings', 'SettingController@update')->name('settings.update');
    
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
    }
);