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

Route::post('register', 'Tenant\RegisterTenantController')->name('register.tenant');

Route::get('/nnn', function () {  
    $r = ['domain' => 'name'];
    return response()->json([ 'data' => $r ]);
});

// Route::group(
//     ['prefix' => 'auth'],
//     function () {
//         Route::post('token', 'Auth\LoginController@login')->name('auth.token');
//         Route::post('logout', 'Auth\LoginController@logout')->name('auth.logout')->middleware(['auth:api']);
//         // Route::get('me', 'AuthController@profile')->name('auth.profile')->middleware(['auth:api']);
//     }
// );

// /**
//  * all route that require user to be full authenticated
//  */
// Route::group(
//     ['middleware' =>  ['auth:api']],
//     function () {
//         Route::get('settings', 'SettingController@index')->name('settings.get');
//         Route::patch('settings', 'SettingController@update')->name('settings.update');
    
//         Route::group(
//             ['prefix' => 'users'],
//             function () {
//                 Route::get('/', 'UserController@index')->name('users.all');
//                 Route::get('/{userId}', 'UserController@show')->name('user.show');
//                 Route::post('/', 'UserController@store')->name('user.create');
//                 Route::patch('/{userId}', 'UserController@update')->name('user.update');
//                 Route::delete('/{userId}', 'UserController@destroy')->name('user.delete');
//                 Route::delete('/{userId}/deactivate', 'UserController@deactivateUser')->name('user.deactivate');
//                 Route::post('/{userId}/activate', 'UserController@activateUser')->name('user.activate');
//                 Route::post('/changepassword', 'UserController@changePassword')->name('user.changePassword');
//             }
//         );

//         Route::group(
//             ['prefix' => 'sectors'],
//             function () {
//                 Route::get('/', 'SectorController@index')->name('sector.all');
//                 Route::get('/{sector_id}', 'SectorController@show')->name('sector.show');
//                 Route::post('/', 'SectorController@store')->name('sector.create');
//                 Route::patch('/{sector_id}', 'SectorController@update')->name('sector.update');
//                 Route::delete('/{sector_id}', 'SectorController@destroy')->name('sector.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'permit-types'],
//             function () {
//                 Route::get('/', 'PermitTypeController@index')->name('permit_type.all');
//                 Route::get('/{permit_type_name}', 'PermitTypeController@show')->name('permit_type.show');
//                 Route::patch('/{permit_type_name}', 'PermitTypeController@update')->name('permit_type.update');
//             }
//         );

//         Route::group(
//             ['prefix' => 'agents'],
//             function () {
//                 Route::get('/', 'AgentController@index')->name('agent.all');
//                 Route::get('/{agent_id}', 'AgentController@show')->name('agent.show');
//                 Route::post('/', 'AgentController@store')->name('agent.create');
//                 Route::patch('/{agent_id}', 'AgentController@update')->name('agent.update');
//                 Route::delete('/{agent_id}', 'AgentController@destroy')->name('agent.delete');
//                 Route::delete('/{agent_id}/deactivate', 'AgentController@deactivate')->name('agent.deactivate');
//                 Route::post('/{agent_id}/activate', 'AgentController@activate')->name('agent.activate');
//             }
//         );

//         Route::group(
//             ['prefix' => 'guides'],
//             function () {
//                 Route::get('/', 'GuideController@index')->name('guide.all');
//                 Route::get('/{guide_id}', 'GuideController@show')->name('guide.show');
//                 Route::post('/', 'GuideController@store')->name('guide.create');
//                 Route::patch('/{guide_id}', 'GuideController@update')->name('guide.update');
//                 Route::delete('/{guide_id}', 'GuideController@destroy')->name('guide.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'vehicles'],
//             function () {
//                 Route::get('/', 'VehicleController@index')->name('vehicle.all');
//                 Route::get('/{vehicle_id}', 'VehicleController@show')->name('vehicle.show');
//                 Route::post('/', 'VehicleController@store')->name('vehicle.create');
//                 Route::patch('/{vehicle_id}', 'VehicleController@update')->name('vehicle.update');
//                 Route::delete('/{vehicle_id}', 'VehicleController@destroy')->name('vehicle.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'road-transfers'],
//             function () {
//                 Route::get('/', 'RoadTransferController@index')->name('road_transfer.all');
//                 Route::get('/{road_transfer_id}', 'RoadTransferController@show')->name('road_transfer.show');
//                 Route::post('/', 'RoadTransferController@store')->name('road_transfer.create');
//                 Route::patch('/{road_transfer_id}', 'RoadTransferController@update')->name('road_transfer.update');
//                 Route::delete('/{road_transfer_id}', 'RoadTransferController@destroy')->name('road_transfer.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'flight-transfers'],
//             function () {
//                 Route::get('/', 'FlightTransferController@index')->name('flight_transfer.all');
//                 Route::get('/{flight_transfer_id}', 'FlightTransferController@show')->name('flight_transfer.show');
//                 Route::post('/', 'FlightTransferController@store')->name('flight_transfer.create');
//                 Route::patch('/{flight_transfer_id}', 'FlightTransferController@update')->name('flight_transfer.update');
//                 Route::delete('/{flight_transfer_id}', 'FlightTransferController@destroy')->name('flight_transfer.delete');
//             }
//         );


//         Route::group(
//             ['prefix' => 'lodges'],
//             function () {
//                 Route::get('/', 'LodgeController@index')->name('lodge.all');
//                 Route::get('/{lodge_id}', 'LodgeController@show')->name('lodge.show');
//                 Route::post('/', 'LodgeController@store')->name('lodge.create');
//                 Route::patch('/{lodge_id}', 'LodgeController@update')->name('lodge.update');
//                 Route::delete('/{lodge_id}', 'LodgeController@destroy')->name('lodge.delete');
//                 Route::patch('/{lodge_id}/star-rating', 'LodgeController@updateStarRating')->name('lodge.starrating');
//                 Route::patch('/{lodge_id}/contracted-rating', 'LodgeController@updateContractedRating')->name('lodge.contractedrating');
//             }
//         );

//         Route::group(
//             ['prefix' => 'lodges/{lodge_id}/rooms'],
//             function () {
//                 Route::get('/', 'RoomController@index')->name('room.all');
//                 Route::get('/{room_id}', 'RoomController@show')->name('room.show');
//                 Route::post('/', 'RoomController@store')->name('room.create');
//                 Route::patch('/{room_id}', 'RoomController@update')->name('room.update');
//                 Route::delete('/{room_id}', 'RoomController@destroy')->name('room.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'lodges/{lodge_id}/activities'],
//             function () {
//                 Route::get('/', 'LodgeActivityController@index')->name('activity.all');
//                 Route::get('/{activity_id}', 'LodgeActivityController@show')->name('activity.show');
//                 Route::post('/', 'LodgeActivityController@store')->name('activity.create');
//                 Route::patch('/{activity_id}', 'LodgeActivityController@update')->name('activity.update');
//                 Route::delete('/{activity_id}', 'LodgeActivityController@destroy')->name('activity.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'lodges/{lodge_id}/facilities'],
//             function () {
//                 Route::get('/', 'LodgeFacilityController@index')->name('facility.all');
//                 Route::get('/{facility_id}', 'LodgeFacilityController@show')->name('facility.show');
//                 Route::post('/', 'LodgeFacilityController@store')->name('activity.create');
//                 Route::patch('/{facility_id}', 'LodgeFacilityController@update')->name('facility.update');
//                 Route::delete('/{facility_id}', 'LodgeFacilityController@destroy')->name('facility.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'lodges/{lodge_id}/seasons'],
//             function () {
//                 Route::get('/', 'SeasonController@index')->name('season.all');
//                 Route::get('/{season_id}', 'SeasonController@show')->name('season.show');
//                 Route::post('/', 'SeasonController@store')->name('season.create');
//                 Route::patch('/{season_id}', 'SeasonController@update')->name('season.update');
//                 Route::delete('/{season_id}', 'SeasonController@destroy')->name('season.delete');
//             }
//         );

//         Route::group(
//             ['prefix' => 'rooms/{room_id}/costs'],
//             function () {
//                 Route::get('/', 'SeasonalRoomCostController@index')->name('cost.all');
//                 Route::patch('/', 'SeasonalRoomCostController@update')->name('cost.update');
//             }
//         );
//     }
// );