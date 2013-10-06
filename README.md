Laravel-Agegate
===============

A Laravel 4 package for adding an age gate to a site

## Installation

Add the following to you composer.json file

    "fbf/laravel-agegate": "dev-master"

Run

    composer update

Add the following to app/config/app.php

    'Fbf\LaravelAgegate\LaravelAgegateServiceProvider'

Publish the config

    php artisan config:publish fbf/laravel-agegate

## Configuration

URI of the agegate page

	'agegate_uri' => 'agegate',

## Usage

Register and apply the filter, add the following to app/filters.php

    Route::filter('agegate', 'LaravelAgegateFilter');

add the following to app/routes.php

    Route::when('my/routes/*', 'agegate');

or

	Route::group(array('before' => 'agegate'), function()
	{
		// My routes
	});