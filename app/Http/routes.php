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

Route::get('/', 'WelcomeController@index');
Route::get('about', 'WelcomeController@about');
Route::get('rules', 'WelcomeController@rules');
Route::get('terms', 'WelcomeController@terms');
Route::get('privacy', 'WelcomeController@privacy');
Route::get('contact', 'WelcomeController@contact');
Route::get('all-leagues', 'WelcomeController@leagues');
Route::get('create', 'WelcomeController@create');

/*

*/
Route::get('profile', ['as'=>'profile', 'uses'=>'WelcomeController@getProfile']);

Route::get('league/{id}', ['as'=>'league', 'uses'=>'WelcomeController@getLeague']);
Route::get('league/{id}/manage', ['as'=>'league-manage', 'uses'=>'LeaguesController@getLeague']);
Route::post('league', ['as'=>'league', 'uses'=>'WelcomeController@getLeague']);


Route::get('choose-movies/{id}', ['as'=>'choose-movies', 'uses'=>'WelcomeController@addMovies']);
Route::post('select-movies', ['as'=>'select-movies', 'uses'=>'LeaguesController@postMultipleMovies']);
Route::get('select-participants/{id}', ['as'=>'select-participants', 'uses'=>'WelcomeController@addParticipants']);
Route::post('choose-participants', ['as'=>'choose-participants', 'uses'=>'LeaguesController@postSelectParticipants']);

Route::post('league-invite', ['as'=>'league-invite', 'uses'=>'LeaguesController@postInvitePlayer']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['middleware'=>'auth'], function() {

        Route::get('users/{id}/disable', ['as'=>'user-disable', 'uses'=>'UsersController@disable']);
        Route::get('users/{id}/enable', ['as'=>'user-enable', 'uses'=>'UsersController@enable']);

        Route::get('leagues/{id}/disable', ['as'=>'league-disable', 'uses'=>'LeaguesController@disable']);
        Route::get('leagues/{id}/enable', ['as'=>'league-enable', 'uses'=>'LeaguesController@enable']);
        Route::get('leagues/{id}/rules', ['as'=>'league-rules', 'uses'=>'LeaguesController@getRules']);
        Route::post('leagues/{id}/rules', ['as'=>'league-rules', 'uses'=>'LeaguesController@postRules']);

        Route::get('league-add-movie/{id}', ['as'=>'league-add-movie', 'uses'=>'LeaguesController@addMovie']);
        Route::post('add-movie/{id}', ['as'=>'add-movie', 'uses'=>'LeaguesController@postMovie']);
        Route::get('league-remove-movie/{id}', ['as'=>'league-remove-movie', 'uses'=>'LeaguesController@removeMovie']);

        Route::get('movies/{id}/disable', ['as'=>'movie-disable', 'uses'=>'MoviesController@disable']);
        Route::get('movies/{id}/enable', ['as'=>'movie-enable', 'uses'=>'MoviesController@enable']);

        Route::get('movie-add-contributor/{id}', ['as'=>'movie-add-contributor', 'uses'=>'MoviesController@addContributor']);
        Route::post('add-contributor/{id}', ['as'=>'add-contributor', 'uses'=>'MoviesController@postContributor']);

        Route::get('movie-add-takings/{id}', ['as'=>'movie-add-takings', 'uses'=>'MoviesController@addTakings']);
        Route::post('add-takings/{id}', ['as'=>'add-takings', 'uses'=>'MoviesController@postTakings']);

        Route::get('movie-add-media/{id}', ['as'=>'movie-add-media', 'uses'=>'MoviesController@addMedia']);
        Route::post('add-media/{id}', ['as'=>'add-media', 'uses'=>'MoviesController@postMedia']);

        Route::get('league-add-player/{id}', ['as'=>'league-add-player', 'uses'=>'LeaguesController@addPlayer']);
        Route::post('add-player/{id}', ['as'=>'add-player', 'uses'=>'LeaguesController@postPlayer']);
        Route::get('admin-dashboard', ['as' => 'admin-dashboard', 'uses'=>'UsersController@adminDashboard']);

        Route::resource('users', 'UsersController');
        Route::resource('movies', 'MoviesController');
        Route::resource('contributors', 'ContributorsController');
        Route::resource('leagues', 'LeaguesController');
        Route::resource('rulesets', 'RuleSetsController');

        Route::get('leagues/{id}/join', 'LeaguesController@join');

        Route::get('dashboard', ['as' => 'dashboard', 'uses'=>'UsersController@usersDashboard']);

        Route::get('auctions', ['as'=>'league-auctions', 'uses'=>'LeaguesController@startAuctions']);
        Route::get('notifyauctions', ['as'=>'notify-auctions', 'uses'=>'LeaguesController@preparePlayersForAuctions']);
});


