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
        Route::resource('export', 'Admin\ExportController');
        Route::get('', ['as' => 'admin.index', 'uses' => 'Admin\AdminController@index']);
        Route::resource('players', 'Admin\PlayerController');
        Route::resource('ajax-teams', 'Admin\AjaxTeamController');
        Route::resource('teams', 'Admin\TeamController');
        Route::resource('leagues', 'Admin\LeagueController');
        Route::resource('ajax-seasons', 'Admin\AjaxSeasonController');
        Route::resource('ajax-messages', 'Admin\AjaxAdminMessageController');
        Route::resource('seasons', 'Admin\SeasonController');
        Route::resource('ranks', 'Admin\RankController');
        Route::get('matches/crawler', 'Admin\MatchController@crawler');
        Route::resource('matches', 'Admin\MatchController');
        Route::resource('matches/{id}/match-events','Admin\EventMatchController');
        Route::resource('/seasons/{id}/matches', 'Admin\MatchSeasonController');
        Route::resource('match-events', 'Admin\MatchEventController');
        Route::resource('users', 'Admin\UserController');
        Route::resource('posts', 'Admin\PostController');
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
// OAuth for pets site
Route::group(['prefix' => 'openAuth', 'middleware' => 'web'], function() {
    Route::get('{provider}', [
        'as' => '{provider}.login',
        'uses' => 'Auth\OAuthController@redirect'
    ]);
    Route::get('{provider}/callback', 'Auth\OAuthController@callback');
});

Route::group(['prefix' => 'auth', 'middleware' => 'web'], function() {
    Route::get('/{social}', [
        'as' => '{social}.login',
        'uses' => 'Auth\SocialiteController@redirectToProvider'
    ]);
    Route::get('/{social}/callback', 'Auth\SocialiteController@handleProviderCallback');
});

Route::get('news', 'NewsController@index');
Route::get('news/{slug}', ['as' => 'news.show', 'uses' => 'NewsController@show']);
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::resource('posts', 'Admin\PostController',
        ['except' => ['index', 'show']]
    );
});
Route::get('news/{slug}', 'NewsController@show');
Route::resource('comments', 'User\CommentController');
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
Route::resource('leagues/{id}/ranks', 'Client\LeagueRankController');
Route::resource('leagues/{id}/schedules', 'Client\LeagueScheduleController');
Route::resource('leagues/{id}/results', 'Client\LeagueResultController');
Route::resource('leagues', 'Client\LeagueController');
Route::resource('matches/{id}/bets', 'Client\MatchBetController');
Route::resource('users/{id}/bets', 'Client\UserBetController');
Route::resource('users/{id}/messages', 'Client\UserMessageController');
Route::resource('ajax-users', 'Client\AjaxUserController');
Route::resource('ajax-messages', 'Client\AjaxMessageController');

Route::get('/test/{provider}/get-wam', function($provider) {
    $cookieName = "userAccessToken_" . $provider . "_" . auth()->user()->id;
    $accessToken = $_COOKIE[$cookieName];
    $http = new GuzzleHttp\Client;
    $response = $http->get('http://local-pets.com/api/wam', [
        'headers' => [
            'accept' => 'application/json',
            'authorization' => 'Bearer ' . $accessToken,
        ],
    ]);
    $providersUser = json_decode ( $response->getBody(), true);
});

Route::get('/test/oauth2', 'TestController@test');
Route::get('/testCallback/{provider}/{resource_id}', 'TestController@testCallback');

