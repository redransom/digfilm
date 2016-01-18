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
Route::get('about', ['as'=>'about', 'uses'=>'WelcomeController@about']);
Route::get('rules', ['as'=>'rules', 'uses'=>'WelcomeController@rules']);
Route::get('terms', ['as'=>'terms', 'uses'=>'WelcomeController@terms']);
Route::get('privacy', ['as'=>'privacy', 'uses'=>'WelcomeController@privacy']);
Route::get('contact', ['as'=>'contact', 'uses'=>'WelcomeController@contact']);

Route::get('all-leagues', 'WelcomeController@leagues');
Route::get('create', 'WelcomeController@create');
Route::get('movie-knowledge/{id}', 'WelcomeController@movieKnow');
Route::get('movie-genre/{id}', 'WelcomeController@movieGenre');
Route::get('register-successful', ['as'=>'register-successful', 'uses'=>'WelcomeController@registerSuccessful']);
Route::get('accept-invite/{id}', ['as'=>'accept-invite', 'uses'=>'LeaguesController@acceptInvite']);
Route::get('decline-invite/{id}', ['as'=>'decline-invite', 'uses'=>'LeaguesController@declineInvite']);
Route::get('email-verified', ['as'=>'email-verified', 'uses'=>'WelcomeController@emailVerified']);
Route::get('genres', 'WelcomeController@genres');
Route::get('newreleases', 'WelcomeController@newreleases');
Route::get('comingsoon', 'WelcomeController@comingsoon');

// Registration routes...
Route::get('auth/register', [
  'as' => 'register', 
  'uses' => 'Auth\AuthController@getRegister'
]);
Route::post('auth/register', 'Auth\AuthController@postRegister');

/*
Need to check for login
*/

Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path', 'uses' => 'UsersController@confirmRegister'
]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['middleware'=>'auth'], function() {

        /* Player routes */
        Route::get('profile', ['as'=>'profile', 'uses'=>'WelcomeController@getProfile']);

        Route::get('league-show/{id}', ['as'=>'league-show', 'uses'=>'WelcomeController@getLeague']);
        Route::get('manage/{id}', ['as'=>'manage', 'uses'=>'WelcomeController@manageLeague']);
        /* See if using a new route will fix it - to keep it away from leagues route below */
        Route::post('league-store', ['as'=>'league-store', 'uses'=>'LeaguesController@store']);

        Route::get('roster/{id}', ['as'=>'roster', 'uses'=>'WelcomeController@getRoster']);
        Route::get('choose-movies/{id}', ['as'=>'choose-movies', 'uses'=>'WelcomeController@addMovies']);
        Route::post('select-movies', ['as'=>'select-movies', 'uses'=>'LeaguesController@postMultipleMovies']);
        Route::get('select-participants/{id}', ['as'=>'select-participants', 'uses'=>'WelcomeController@addParticipants']);
        Route::post('choose-participants', ['as'=>'choose-participants', 'uses'=>'LeaguesController@postSelectParticipants']);

        Route::post('league-invite', ['as'=>'league-invite', 'uses'=>'LeaguesController@postInvitePlayer']);
        Route::get('place-bid/{id}', ['as'=>'place-auction-bid', 'uses'=>'AuctionsController@placeBid']);
        Route::get('join-league/{id}', ['as'=>'join-league', 'uses'=>'LeaguesController@join']);

        Route::post('players/{id}/rules', ['as'=>'player-rules', 'uses'=>'LeaguesController@postPlayerRules']);

        /* Admin routes */

        /* Setting Entrust to ensure permissions are correct */
        Entrust::routeNeedsRole('place-auction-bid', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('choose-movies*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('league-invite*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('choose-participants/*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('dashboard', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('manage', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('league-store', array('Admin', 'Player'), Redirect::to('/'), false);
        Entrust::routeNeedsRole('join-league', ['Player'], Redirect::to('/'));

        Entrust::routeNeedsRole('leagues', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('admin-dashboard', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('user-disable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('user-enable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('users', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('users*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('league-disable', ['Admin'], Redirect::to('/'));
        
        Entrust::routeNeedsRole('movies*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('contributors', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('contributors*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('leagues/*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('league/*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('rulesets*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('auctions', ['Admin'], Redirect::to('/'));

        Entrust::routeNeedsRole('league-disable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('league-enable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('movie-disable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('movie-enable', ['Admin'], Redirect::to('/'));

        Route::put('movies-admin-search', ['as'=>'movies-admin-search', 'uses'=>'MoviesController@index']);
        Route::put('users-admin-search', ['as'=>'users-admin-search', 'uses'=>'UsersController@index']);

        Route::get('users/{id}/disable', ['as'=>'user-disable', 'uses'=>'UsersController@disable']);
        Route::get('users/{id}/enable', ['as'=>'user-enable', 'uses'=>'UsersController@enable']);

        /* Leagues Routes */
        Route::get('leagues/{id}/disable', ['as'=>'league-disable', 'uses'=>'LeaguesController@disable']);
        Route::get('leagues/{id}/enable', ['as'=>'league-enable', 'uses'=>'LeaguesController@enable']);
        Route::get('leagues/{id}/rules', ['as'=>'league-rules', 'uses'=>'LeaguesController@getRules']);
        Route::post('leagues/{id}/rules', ['as'=>'league-rules', 'uses'=>'LeaguesController@postRules']);
        Route::get('leagues/{id}/movie', ['as'=>'league-add-movie', 'uses'=>'LeaguesController@addMovie']);
        Route::post('leagues/{id}/movie', ['as'=>'add-movie', 'uses'=>'LeaguesController@postMovie']);
        Route::get('leagues/{id}/removemovie', ['as'=>'league-remove-movie', 'uses'=>'LeaguesController@removeMovie']);
        Route::get('leagues/{id}/removeplayer', ['as'=>'league-remove-player', 'uses'=>'LeaguesController@removePlayer']);
        Route::get('leagues/{id}/player', ['as'=>'league-add-player', 'uses'=>'LeaguesController@addPlayer']);
        Route::post('leagues/{id}/player', ['as'=>'add-player', 'uses'=>'LeaguesController@postPlayer']);

        /* all movies routes */
        Route::get('movies/{id}/disable', ['as'=>'movie-disable', 'uses'=>'MoviesController@disable']);
        Route::get('movies/{id}/enable', ['as'=>'movie-enable', 'uses'=>'MoviesController@enable']);
        Route::get('movies/{id}/removemedia', ['as'=>'movie-remove-media', 'uses'=>'MoviesController@removeMedia']);
        Route::get('movies/{id}/contributor', ['as'=>'movie-add-contributor', 'uses'=>'MoviesController@addContributor']);
        Route::post('movies/{id}/contributor', ['as'=>'add-contributor', 'uses'=>'MoviesController@postContributor']);
        Route::get('movies/{id}/takings', ['as'=>'movie-add-takings', 'uses'=>'MoviesController@addTakings']);
        Route::post('movies/{id}/takings', ['as'=>'add-takings', 'uses'=>'MoviesController@postTakings']);
        Route::get('movies/{id}/media', ['as'=>'movie-add-media', 'uses'=>'MoviesController@addMedia']);
        Route::post('movies/{id}/media', ['as'=>'add-media', 'uses'=>'MoviesController@postMedia']);


        Route::get('admin-dashboard', ['as' => 'admin-dashboard', 'uses'=>'UsersController@adminDashboard']);

        Route::get('auctions/{status?}', ['as'=>'auctions', 'uses'=>'AuctionsController@index']);
        Route::get('leagues/{status?}', ['as'=>'leagues', 'uses'=>'LeaguesController@index']);
        Route::get('create-league', ['as'=>'league-create', 'uses'=>'LeaguesController@create']);
        Route::get('league/{id}', ['as'=>'leagues', 'uses'=>'LeaguesController@show']);

        Route::resource('users', 'UsersController');
        Route::resource('movies', 'MoviesController');
        Route::resource('contributors', 'ContributorsController');
        Route::resource('leagues', 'LeaguesController');
        Route::resource('rulesets', 'RuleSetsController');
        Route::resource('auctions', 'AuctionsController');

        Route::get('dashboard', ['as' => 'dashboard', 'uses'=>'UsersController@usersDashboard']);


        /* Auction tasks */
        Route::get('auction-close/{id}', ['as'=>'close-auction', 'uses'=>'AuctionsController@close']);

});

/* cron jobs */
Route::get('start-auctions/5Htzx6V6nud998R353kz', ['as'=>'league-auctions', 'uses'=>'LeaguesController@startAuctions']);
Route::get('notify-auctions/63zdE1TnIWUQ444PHPNa', ['as'=>'notify-auctions', 'uses'=>'LeaguesController@preparePlayersForAuctions']);
Route::get('phase1-run-auctions/bf2Kc6hOuU7CO948h60s', ['as'=>'phase1-auctions', 'uses'=>'AuctionsController@executeAuctions']);
Route::get('phase2-run-auctions/RBbgCtpSeTsKzM0UgoCg', ['as'=>'load-movies', 'uses'=>'AuctionsController@loadNextMovies']);
Route::get('clear-endtime-auctions/Qjr13b0VbElXE8TdmcTc', ['as'=>'clear-endtime-auctions', 'uses'=>'AuctionsController@clearEndTimeAuctions']);
Route::get('clear-timeout-auctions/N4KuW01N6cVmQZPTQcxd', ['as'=>'clear-timeout-auctions', 'uses'=>'AuctionsController@clearTimeoutAuctions']);
Route::get('prep-cleared-auctions/N4KuW01N6cVmQZPTQcxd', ['as'=>'prepare-clear-auctions', 'uses'=>'AuctionsController@prepareClearedAuctions']);
Route::get('close-league-auctions/NJWKIKWqlVjHfPNyI3cJ', ['as'=>'close-league-auctions', 'uses'=>'AuctionsController@completeLeagues']);
Route::get('close-bad-leagues/H8BFC2Wp87DBA2b683uM', ['as'=>'close-bad-leagues', 'uses'=>'LeaguesController@closeLeaguesWhereStartDatePassed']);
Route::get('end-leagues/55su3532IWH0968114eG', ['as'=>'end-leagues', 'uses'=>'LeaguesController@endLeagueWithWinners']);

