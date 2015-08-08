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
/** 
Players Breadcrumbs
*/
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->push('Home', route('dashboard'));
});