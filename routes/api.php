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
    }
);