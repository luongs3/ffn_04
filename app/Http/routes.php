<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::auth();
Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/players/export', ['as' => 'admin.players.export', 'uses' => 'Admin\PlayerController@export']);
        Route::resource('players', 'Admin\PlayerController');
        Route::get('/teams/export', ['as' => 'admin.teams.export', 'uses' => 'Admin\TeamController@export']);
        Route::resource('teams', 'Admin\TeamController');
        Route::get('/leagues/export', ['as' => 'admin.leagues.export', 'uses' => 'Admin\LeagueController@export']);
        Route::resource('leagues', 'Admin\LeagueController');
        Route::get('/seasons/export', ['as' => 'admin.seasons.export', 'uses' => 'Admin\SeasonController@export']);
        Route::resource('seasons', 'Admin\SeasonController');
    });
});
Route::get('/home', 'HomeController@index');
Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/logout', 'HomeController@getLogout');
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', ['as' => 'register', 'uses' => 'Auth\AuthController@postRegister']);
Route::get('/register/verify/{confirmationCode}', 'Auth\AuthController@confirm');
Route::group(['prefix' => 'auth', 'middleware' => 'web'], function() {
    Route::get('/{social}', [
        'as' => '{social}.login',
        'uses' => 'Auth\SocialiteController@redirectToProvider'
    ]);
    Route::get('/{social}/callback', 'Auth\SocialiteController@handleProviderCallback');
});

/*
 * Football News
 */
Route::get('news', 'NewsController@index');
Route::get('news/{slug}', 'NewsController@show');
