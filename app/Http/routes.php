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