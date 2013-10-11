Laravel-Agegate
===============

A Laravel 4 package for adding an age gate to a site

## Features

* Redirects requests for guarded routes to agegate URL
* Agegate form with input type=date or select tags for year, month and day
* Configurable url for agegate, minimum age, cookie name, cookie value
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

The input type to use. Choices are:
"date" for html5 input type="date"
"select" for 3 select tags for day, month and year

	'input_type' => 'select',

The name of the cookie to set. Change this to whatever you want

	'cookie_name' => 'age_ok',

The value of the cookie to set. Change this to something unique

	'cookie_val' => 'hell yeah!',

The view that should be rendered for the agegate. You can use the bundled view, or specify your own and use @include('laravel-agegate::agegate') to get the agegate form and validation errors

	'view' => 'laravel-agegate::agegate',

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

If you are using route prefixes in combination with the agegate filter, you can do the following:

	Route::get(
	    Request::segment(1).'/'.Config::get('laravel-agegate::agegate_uri'),
	    'Fbf\LaravelAgegate\AgegateController@agegate'
	);

	Route::post(
	    Request::segment(1).'/'.Config::get('laravel-agegate::agegate_uri'),
	    array(
	        'before' => 'csrf',
	        'uses' => 'Fbf\LaravelAgegate\AgegateController@doAgegate'
	    )
	);
