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
Route::get('profile', ['as'=>'profile', 'uses'=>'WelcomeController@getProfile']);

Route::get('leagues/{id}/join', 'LeaguesController@join');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('users/{id}/disable', ['as'=>'user-disable', 'uses'=>'UsersController@disable']);
Route::get('users/{id}/enable', ['as'=>'user-enable', 'uses'=>'UsersController@enable']);

Route::get('leagues/{id}/disable', ['as'=>'league-disable', 'uses'=>'LeaguesController@disable']);
Route::get('leagues/{id}/enable', ['as'=>'league-enable', 'uses'=>'LeaguesController@enable']);

Route::get('movies/{id}/disable', ['as'=>'movie-disable', 'uses'=>'MoviesController@disable']);
Route::get('movies/{id}/enable', ['as'=>'movie-enable', 'uses'=>'MoviesController@enable']);

Route::get('movie-add-contributor/{id}', ['as'=>'movie-add-contributor', 'uses'=>'MoviesController@addContributor']);
Route::post('add-contributor/{id}', ['as'=>'add-contributor', 'uses'=>'MoviesController@postContributor']);

Route::get('league-add-player/{id}', ['as'=>'league-add-player', 'uses'=>'LeaguesController@addPlayer']);
Route::post('add-player/{id}', ['as'=>'add-player', 'uses'=>'LeaguesController@postPlayer']);

Route::get('admin-dashboard', ['as' => 'admin-dashboard', 'uses'=>'UsersController@adminDashboard']);
Route::get('dashboard', ['as' => 'dashboard', 'uses'=>'UsersController@usersDashboard']);
Route::resource('users', 'UsersController');
Route::resource('movies', 'MoviesController');
Route::resource('contributors', 'ContributorsController');
Route::resource('leagues', 'LeaguesController');