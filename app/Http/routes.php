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
Route::group(['middleware' => 'admin'], function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/players/export', ['as' => 'admin.players.export', 'uses' => 'Admin\PlayerController@export']);
        Route::resource('players', 'Admin\PlayerController');
        Route::get('/teams/export', ['as' => 'admin.teams.export', 'uses' => 'Admin\TeamController@export']);
        Route::get('/teams/ajax', ['as' => 'admin.teams.ajax', 'uses' => 'Admin\TeamController@ajaxTeams']);
        Route::resource('teams', 'Admin\TeamController');
        Route::get('/leagues/export', ['as' => 'admin.leagues.export', 'uses' => 'Admin\LeagueController@export']);
        Route::resource('leagues', 'Admin\LeagueController');
        Route::get('/seasons/export', ['as' => 'admin.seasons.export', 'uses' => 'Admin\SeasonController@export']);
        Route::get('/seasons/ajax', ['as' => 'admin.seasons.ajax', 'uses' => 'Admin\SeasonController@ajaxSeasons']);
        Route::resource('seasons', 'Admin\SeasonController');
        Route::get('/ranks/export', ['as' => 'admin.ranks.export', 'uses' => 'Admin\RankController@export']);
        Route::resource('ranks', 'Admin\RankController');
        Route::get('/matches/export', ['as' => 'admin.matches.export', 'uses' => 'Admin\MatchController@export']);
        Route::get('/matches/{id}/match-events', ['as' => 'admin.matches.match-events', 'uses' => 'Admin\MatchController@matchEvents']);Route::get('/matches/{id}/match-events', ['as' => 'admin.matches.match-events', 'uses' => 'Admin\MatchController@matchEvents']);
        Route::resource('matches', 'Admin\MatchController');
        Route::get('/match-events/export', ['as' => 'admin.match-events.export', 'uses' => 'Admin\MatchEventController@export']);
        Route::get('/match-events/match-names', ['as' => 'admin.match-events.match-names', 'uses' => 'Admin\MatchEventController@getMatchNames']);
        Route::resource('match-events', 'Admin\MatchEventController');
        Route::get('users/export', ['as'  => 'admin.users.export', 'uses' => 'Admin\UserController@export']);
        Route::resource('users', 'Admin\UserController');
    });
});

// Client
Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);
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

Route::get('news', 'NewsController@index');
Route::get('news/{slug}', 'NewsController@show');
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::resource('posts', 'Admin\PostController',
        ['except' => ['index', 'show']]
    );
});
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function() {
    Route::resource('profiles', 'User\UserController');
    Route::get('/profiles/getChangePassword/{id}', [
        'as' => 'user.profiles.getChangePassword',
        'uses' => 'User\UserController@getChangePassword'
    ]);
    Route::post('/profiles/postChangePassword/{id}', [
        'as' => 'user.profiles.postChangePassword',
        'uses' => 'User\UserController@postChangePassword'
    ]);
});

Route::get('/matches/{id}/match-events', ['as' => 'matches.match-events', 'uses' => 'Admin\MatchController@matchEvents']);
Route::resource('matches', 'Client\MatchController');
Route::resource('players', 'Client\PlayerController');
Route::resource('teams', 'Client\TeamController');
Route::group(['prefix' => 'leagues/{id}'], function () {
    Route::get('rank', ['as' => 'leagues.rank', 'uses' => 'Client\LeagueController@rank']);
    Route::get('schedule', ['as' => 'leagues.schedule', 'uses' => 'Client\LeagueController@schedule']);
    Route::get('result', ['as' => 'leagues.result', 'uses' => 'Client\LeagueController@result']);
});
Route::resource('leagues', 'Client\LeagueController');
