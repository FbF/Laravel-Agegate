Laravel-Agegate
===============

A Laravel 4 package for adding an age gate to a site

## Features

* Redirects requests for guarded routes to agegate URL
* Agegate form with input type=date
* Configurable minimum age
* Sets 'forever' cookie if user is old enough
* Redirects user back to the URL they were trying to access

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

The minimum age to access the site

	'minimum_age' => 18,

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