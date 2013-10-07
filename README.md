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

Register the filter by adding the following to app/filters.php

    Route::filter('agegate', 'Fbf\LaravelAgegate\LaravelAgegateFilter');

and apply it to the routes you want to protect by adding the following to app/routes.php

    Route::when('my/routes/*', 'agegate');

or

	Route::group(array('before' => 'agegate'), function()
	{
		// My routes
	});

You also need to add the agegate routes to your app/routes.php, for example:

    Route::get(
    	Config::get('laravel-agegate::agegate_uri'),
    	'Fbf\LaravelAgegate\AgegateController@agegate'
	);

	Route::post(
		Config::get('laravel-agegate::agegate_uri'),
		array(
			'before' => 'csrf',
			'uses' => 'Fbf\LaravelAgegate\AgegateController@doAgegate'
		)
	);

(I used to have them bundled in the package, but I needed to attach more before filters to the routes, for example mcamara/laravel-localization, so needed to put them in the app/routes.php file instead)