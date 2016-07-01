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
Route::post('contact', ['as'=>'contact', 'uses'=>'WelcomeController@postContact']);
Route::post('search-results', ['as'=>'search-results', 'uses'=>'WelcomeController@postSearch']);

Route::get('all-leagues', 'WelcomeController@leagues');
Route::get('create', 'WelcomeController@create');
Route::get('movie-knowledge/{id}', 'WelcomeController@movieKnow');
Route::get('all-movies', ['as'=>'all-movies', 'uses'=>'WelcomeController@movies']);
Route::get('movie-genre/{id}', ['as'=>'movie-genre', 'uses'=>'WelcomeController@movieGenre']);
Route::get('news-detail/{id}', ['as'=>'news-detail', 'uses'=>'WelcomeController@newsDetail']);
Route::get('news', ['as'=>'news', 'uses'=>'WelcomeController@newsArticles']);
Route::get('league-made/{id}', ['as'=>'league-made', 'uses'=>'WelcomeController@leagueMade']);

Route::get('register-successful', ['as'=>'register-successful', 'uses'=>'WelcomeController@registerSuccessful']);
Route::get('accept-invite/{id}', ['as'=>'accept-invite', 'uses'=>'LeaguesController@acceptInvite']);
Route::get('decline-invite/{id}', ['as'=>'decline-invite', 'uses'=>'LeaguesController@declineInvite']);
Route::get('email-verified', ['as'=>'email-verified', 'uses'=>'WelcomeController@emailVerified']);
Route::get('genres', 'WelcomeController@genres');
Route::get('newreleases', ['as'=>'newreleases', 'uses'=>'WelcomeController@newreleases']);
Route::get('comingsoon', ['as'=>'comingsoon', 'uses'=>'WelcomeController@comingsoon']);
Route::get('league-show/{id}', ['as'=>'league-show', 'uses'=>'WelcomeController@getLeague']);

// Registration routes...
Route::get('auth/register', [
  'as' => 'register', 
  'uses' => 'Auth\AuthController@getRegister'
]);
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auth/reset', [
  'as' => 'reset', 
  'uses' => 'Auth\AuthController@getReset'
]);

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
        Route::get('profile/{name}', ['as'=>'profile', 'uses'=>'WelcomeController@getProfile']);
        Route::get('edit-profile', ['as'=>'edit-profile', 'uses'=>'WelcomeController@getEditUser']);
        Route::put('update-profile/{id}', ['as'=>'update-profile', 'uses'=>'UsersController@update']);

        Route::get('league-play/{id}/{col?}/{order?}', ['as'=>'league-play', 'uses'=>'WelcomeController@getLeaguePlay']);
        Route::get('manage/{id}', ['as'=>'manage', 'uses'=>'WelcomeController@manageLeague']);
        /* See if using a new route will fix it - to keep it away from leagues route below */
        Route::post('league-store', ['as'=>'league-store', 'uses'=>'LeaguesController@store']);
        Route::post('add-message/{id}', ['as'=>'add-message', 'uses'=>'LeaguesController@addMessage']);

        Route::get('roster/{id}', ['as'=>'roster', 'uses'=>'WelcomeController@getRoster']);
        Route::get('choose-movies/{id}', ['as'=>'choose-movies', 'uses'=>'WelcomeController@addMovies']);
        Route::post('select-movies', ['as'=>'select-movies', 'uses'=>'LeaguesController@postMultipleMovies']);
        Route::get('select-participants/{id}', ['as'=>'select-participants', 'uses'=>'WelcomeController@addParticipants']);
        Route::post('choose-participants', ['as'=>'choose-participants', 'uses'=>'LeaguesController@postSelectParticipants']);

        Route::post('league-invite', ['as'=>'league-invite', 'uses'=>'LeaguesController@postInvitePlayer']);
        Route::get('place-bid/{id}', ['as'=>'place-auction-bid', 'uses'=>'AuctionsController@placeBid']);
        Route::get('join-league/{id}', ['as'=>'join-league', 'uses'=>'LeaguesController@join']);

        Route::post('players/{id}/rules', ['as'=>'player-rules', 'uses'=>'LeaguesController@postPlayerRules']);
        Route::get('config-rules/{id}', ['as'=>'config-rules', 'uses'=>'WelcomeController@configRules']);

        /* Admin routes */

        /* Setting Entrust to ensure permissions are correct */
        Entrust::routeNeedsRole('place-auction-bid', ['Player'], Redirect::to('/'));
        //Entrust::routeNeedsRole('update-profile*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('choose-movies*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('league-invite*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('choose-participants/*', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('dashboard', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('manage', ['Player'], Redirect::to('/'));
        Entrust::routeNeedsRole('league-store', array('Admin', 'Player'), Redirect::to('/'), false);
        Entrust::routeNeedsRole('join-league', ['Player'], Redirect::to('/'));

        Entrust::routeNeedsRole('leagues', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('admin-dashboard', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('user', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('user-disable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('user-enable', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('users', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('users*', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('sitecontent', ['Admin'], Redirect::to('/'));
        Entrust::routeNeedsRole('sitecontents*', ['Admin'], Redirect::to('/'));
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
        Entrust::routeNeedsRole('movie-delete', ['Admin'], Redirect::to('/'));

        Route::put('movies-admin-search', ['as'=>'movies-admin-search', 'uses'=>'MoviesController@index']);
        Route::put('users-admin-search', ['as'=>'users-admin-search', 'uses'=>'UsersController@index']);

/*        Route::get('user/{id}', ['as'=>'user', 'uses'=>'UsersController@show']);
*/
/*        Route::get('users/{id}/disable', ['as'=>'user-disable', 'uses'=>'UsersController@disable']);
        Route::get('users/{id}/enable', ['as'=>'user-enable', 'uses'=>'UsersController@enable']);
*/
        /* Leagues Routes */
        Route::get('leagues/{status?}/{col?}/{order?}', ['as'=>'leagues', 'uses'=>'LeaguesController@index']);
        Route::get('league/{id}', ['as'=>'league', 'uses'=>'LeaguesController@show']);
        Route::get('league/{id}/edit', ['as'=>'league-edit', 'uses'=>'LeaguesController@edit']);
        Route::post('league/{id}/edit', ['as'=>'league-edit', 'uses'=>'LeaguesController@update']);
        Route::get('league/{id}/disable', ['as'=>'league-disable', 'uses'=>'LeaguesController@disable']);
        Route::get('league/{id}/enable', ['as'=>'league-enable', 'uses'=>'LeaguesController@enable']);
        Route::get('league/{id}/rules', ['as'=>'league-rules', 'uses'=>'LeaguesController@getRules']);
        Route::post('league/{id}/rules', ['as'=>'league-rules', 'uses'=>'LeaguesController@postRules']);
        Route::get('league/{id}/movie', ['as'=>'league-add-movie', 'uses'=>'LeaguesController@addMovie']);
        Route::post('league/{id}/movie', ['as'=>'add-movie', 'uses'=>'LeaguesController@postMovie']);
        Route::get('league/{id}/removemovie', ['as'=>'league-remove-movie', 'uses'=>'LeaguesController@removeMovie']);
        Route::get('league/{id}/removeplayer', ['as'=>'league-remove-player', 'uses'=>'LeaguesController@removePlayer']);
        Route::get('league/{id}/player', ['as'=>'league-add-player', 'uses'=>'LeaguesController@addPlayer']);
        Route::post('league/{id}/player', ['as'=>'add-player', 'uses'=>'LeaguesController@postPlayer']);

        /* User Routes */
        Route::get('user', ['as'=>'user-create', 'uses'=>'UsersController@create']);
        Route::get('users/{type}', ['as'=>'users', 'uses'=>'UsersController@index']);
        Route::get('user/{id}', ['as'=>'user', 'uses'=>'UsersController@show']);
        Route::get('user/{id}/edit', ['as'=>'user-edit', 'uses'=>'UsersController@edit']);
        Route::post('user/{id}/edit', ['as'=>'user-edit', 'uses'=>'UsersController@update']);
        Route::get('user/{id}/disable', ['as'=>'user-disable', 'uses'=>'UsersController@disable']);
        Route::get('user/{id}/enable', ['as'=>'user-enable', 'uses'=>'UsersController@enable']);

        /* all movies routes */
        Route::get('movies/{status}/{col?}/{order?}', ['as'=>'movies', 'uses'=>'MoviesController@index']);
        Route::get('movie-create', ['as'=>'movie.create', 'uses'=>'MoviesController@create']);
        Route::get('movie-show/{id?}', ['as'=>'movie-show', 'uses'=>'MoviesController@show']);
        Route::get('movie-disable/{id}/{search?}', ['as'=>'movie-disable', 'uses'=>'MoviesController@disable']);
        Route::get('movie-enable/{id}/{search?}', ['as'=>'movie-enable', 'uses'=>'MoviesController@enable']);
        Route::get('movie-delete/{id}', ['as'=>'movie-delete', 'uses'=>'MoviesController@destroy']);
        Route::get('movie/{id}/removemedia', ['as'=>'movie-remove-media', 'uses'=>'MoviesController@removeMedia']);
        Route::get('movie/{id}/edit', ['as'=>'movie-edit', 'uses'=>'MoviesController@edit']);
        Route::get('movie/{id}/contributor', ['as'=>'movie-add-contributor', 'uses'=>'MoviesController@addContributor']);
        Route::post('movie/{id}/contributor', ['as'=>'add-contributor', 'uses'=>'MoviesController@postContributor']);
        Route::get('movie/{id}/takings/{date?}', ['as'=>'movie-add-takings', 'uses'=>'MoviesController@addTakings']);
        Route::post('movie/{id}/takings', ['as'=>'add-takings', 'uses'=>'MoviesController@postTakings']);
        Route::get('movie/{id}/media', ['as'=>'movie-add-media', 'uses'=>'MoviesController@addMedia']);
        Route::post('movie/{id}/media', ['as'=>'add-media', 'uses'=>'MoviesController@postMedia']);

        /* all sitecontent routes */
//        Route::get('sitecontent', ['as'=>'user-create', 'uses'=>'SiteContentsController@create']);
        Route::get('sitecontents/{type?}', ['as'=>'sitecontents', 'uses'=>'SiteContentsController@index']);
        Route::get('sitecontent/create/{type}', ['as'=>'sitecontent-create', 'uses'=>'SiteContentsController@create']);
        Route::post('sitecontent-update', ['as'=>'sitecontent-update', 'uses'=>'LeaguesController@update']);
        Route::get('sitecontent/{id}/disable', ['as'=>'content-disable', 'uses'=>'SiteContentsController@disable']);
        Route::get('sitecontent/{id}/enable', ['as'=>'content-enable', 'uses'=>'SiteContentsController@enable']);

        Route::get('admin-dashboard', ['as' => 'admin-dashboard', 'uses'=>'AdminController@index']);

        Route::get('auctions/{status?}', ['as'=>'auctions', 'uses'=>'AuctionsController@index']);
        //Route::get('leagues/{status?}', ['as'=>'leagues', 'uses'=>'LeaguesController@index']);
        Route::get('create-league', ['as'=>'league-create', 'uses'=>'LeaguesController@create']);


        Route::resource('users', 'UsersController');
        Route::resource('sitecontent', 'SiteContentsController');
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
/*Route::get('clear-endtime-auctions/Qjr13b0VbElXE8TdmcTc', ['as'=>'clear-endtime-auctions', 'uses'=>'AuctionsController@clearEndTimeAuctions']);
Route::get('clear-timeout-auctions/N4KuW01N6cVmQZPTQcxd', ['as'=>'clear-timeout-auctions', 'uses'=>'AuctionsController@clearTimeoutAuctions']);
*/Route::get('prep-cleared-auctions/N4KuW01N6cVmQZPTQcxd', ['as'=>'prepare-clear-auctions', 'uses'=>'AuctionsController@prepareClearedAuctions']);
Route::get('close-league-auctions/NJWKIKWqlVjHfPNyI3cJ', ['as'=>'close-league-auctions', 'uses'=>'AuctionsController@completeLeagues']);
Route::get('close-bad-leagues/H8BFC2Wp87DBA2b683uM', ['as'=>'close-bad-leagues', 'uses'=>'LeaguesController@closeLeaguesWhereStartDatePassed']);
Route::get('end-leagues/55su3532IWH0968114eG', ['as'=>'end-leagues', 'uses'=>'LeaguesController@endLeagueWithWinners']);
Route::get('disable-movies/8977H5F6hbBg28A047Wg', ['as'=>'disable-old-movies', 'uses'=>'MoviesController@disableOldMovies']);
