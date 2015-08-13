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

Breadcrumbs::register('leagues', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-dashboard');
    $breadcrumbs->push('Leagues', route('leagues.index'));
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

/** 
Players Breadcrumbs
*/
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('dashboard'));
});