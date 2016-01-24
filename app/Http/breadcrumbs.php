<?php

/** 
Admin Breadcrumbs
*/
Breadcrumbs::register('admin-dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('admin-dashboard'));
});

Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Users', route('users.index'));
});

Breadcrumbs::register('user-add', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Add User', route('users.create'));
});

Breadcrumbs::register('user-edit', function($breadcrumbs, $user)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('Edit User', route('users.edit', array('id'=>$user->id)));
});

Breadcrumbs::register('movies', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Movies', route('movies.index'));
});

Breadcrumbs::register('movie-add', function($breadcrumbs)
{
    $breadcrumbs->parent('movies');
    $breadcrumbs->push('Add Movie');
});

Breadcrumbs::register('movie-edit', function($breadcrumbs, $movie)
{
    $breadcrumbs->parent('movies');
    $breadcrumbs->push('Edit Movie', route('movies.edit', $movie->id));
});

Breadcrumbs::register('movie-show', function($breadcrumbs, $movie)
{
    $breadcrumbs->parent('movies');
    $breadcrumbs->push('Movie Details', route('movies.show', $movie->id));
});

Breadcrumbs::register('movie-contributor', function($breadcrumbs, $movie)
{
    $breadcrumbs->parent('movies');
    $breadcrumbs->push('Add Contributor to Movie', route('movie-add-contributor', $movie->id));
});

Breadcrumbs::register('movie-takings', function($breadcrumbs, $movie)
{
    $breadcrumbs->parent('movies');
    $breadcrumbs->push('Add Takings to Movie', route('movie-add-takings', $movie->id));
});

Breadcrumbs::register('movie-media', function($breadcrumbs, $movie)
{
    $breadcrumbs->parent('movies');
    $breadcrumbs->push('Add Media to Movie', route('movie-add-media', $movie->id));
});

Breadcrumbs::register('contributors', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Contributors', route('contributors.index'));
});

Breadcrumbs::register('contributor-edit', function($breadcrumbs, $contributor)
{
    $breadcrumbs->parent('contributors');
    $breadcrumbs->push('Edit Contributor', route('contributors.edit', $contributor->id));
});

Breadcrumbs::register('contributor-add', function($breadcrumbs)
{
    $breadcrumbs->parent('contributors');
    $breadcrumbs->push('Add Contributor');
});

Breadcrumbs::register('contributor-show', function($breadcrumbs, $contributor)
{
    $breadcrumbs->parent('contributors');
    $breadcrumbs->push('Contributor Details', route('contributors.show', $contributor->id));
});

Breadcrumbs::register('sitecontents', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Content', route('sitecontent.index'));
});

Breadcrumbs::register('sitecontent-add', function($breadcrumbs)
{
    $breadcrumbs->parent('sitecontents');
    $breadcrumbs->push('Add Site Content');
});

Breadcrumbs::register('sitecontent-edit', function($breadcrumbs, $sitecontent)
{
    $breadcrumbs->parent('sitecontents');
    $breadcrumbs->push('Site Content Details', route('sitecontent.edit', $sitecontent->id));
});

Breadcrumbs::register('leagues', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Leagues', route('leagues.index'));
});

Breadcrumbs::register('league-add', function($breadcrumbs)
{
    $breadcrumbs->parent('leagues');
    $breadcrumbs->push('Add League');
});

Breadcrumbs::register('league-edit', function($breadcrumbs, $league)
{
    $breadcrumbs->parent('leagues');
    $breadcrumbs->push('Edit League', route('leagues.edit', $league->id));
});

Breadcrumbs::register('league-show', function($breadcrumbs, $league)
{
    $breadcrumbs->parent('leagues');
    $breadcrumbs->push('League Details', route('leagues.show', $league->id));
});

Breadcrumbs::register('league-player', function($breadcrumbs, $league)
{
    $breadcrumbs->parent('leagues');
    $breadcrumbs->push('Add Player to League', route('league-add-player', $league->id));
});

Breadcrumbs::register('league-movie', function($breadcrumbs, $league)
{
    $breadcrumbs->parent('leagues');
    $breadcrumbs->push('Add Movie to League', route('league-add-movie', $league->id));
});

Breadcrumbs::register('league-rule', function($breadcrumbs, $league)
{
    $breadcrumbs->parent('leagues');
    $breadcrumbs->push('Edit League Rules', route('league-rules', $league->id));
});

Breadcrumbs::register('rulesets', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Rule Sets', route('rulesets.index'));
});

Breadcrumbs::register('ruleset-add', function($breadcrumbs)
{
    $breadcrumbs->parent('rulesets');
    $breadcrumbs->push('Add Rule Set');
});

Breadcrumbs::register('ruleset-edit', function($breadcrumbs, $ruleset)
{
    $breadcrumbs->parent('rulesets');
    $breadcrumbs->push('Edit Rule Set', route('rulesets.edit', $ruleset->id));
});

Breadcrumbs::register('auctions', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Auctions', route('auctions.index'));
});

/** 
Players Breadcrumbs
*/

Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Home');
});

Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Your Dashboard', route('dashboard'));
});

Breadcrumbs::register('about', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About', route('about'));
});

Breadcrumbs::register('rules', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Rules', route('rules'));
});

Breadcrumbs::register('terms', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Terms & Conditions', route('terms'));
});

Breadcrumbs::register('privacy', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Privacy Policy', route('privacy'));
});

Breadcrumbs::register('contact', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Contact Us', route('contact'));
});

Breadcrumbs::register('register-successful', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Register Success', route('register-successful'));
});

Breadcrumbs::register('email-verified', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Email Verified', route('email-verified'));
});

Breadcrumbs::register('league-show', function($breadcrumbs, $object)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('League Details', route('league-show', [$object->id]));
});