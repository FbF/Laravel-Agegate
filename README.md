Laravel-Agegate
===============

A Laravel 4 package for adding an age gate to a site

## Features

* Redirects requests for guarded routes to agegate URL
* Agegate form with input type=date or select tags for year, month and day
* Configurable url for agegate, minimum age, cookie name, cookie value
* Sets 'forever' cookie if user is old enough
* Redirects user back to the URL they were trying to access
* Optionally allows bots/crawlers/spiders through age gate using one of 3 approaches

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

The mode for allowed user agents (see section on Allowing bots etc below)

	'allowed_user_agents.mode' => 'phpbrowscap_crawler'

The strings for allowed user agents, for the mode = exact or mode = contains setting (see section on Allowing bots etc below)

	'allowed_user_agents.strings' => array(...)

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

## Allowing bots/crawlers/spiders through

You can prevent them by setting the config setting `allowed_user_agents.mode` to `none`

If you do want to allow certain user agents through the package provides 3 approaches:

# Using `phpbrowscap_crawler`

  This is a composer package that is installed as a dependency of the agegate package.

  Simply it is a version of the browscap project that doesn't require you to have specified
  the path to the browscap.ini file in your php.ini.

  The project maintains an up-to-date list of platforms, browsers, versions and capabilities
  and also details of crawlers. It's the crawlers data that this package uses.

  The way it works is to fetch and cache a copy of the latest browscap.ini file and create a
  php array cache version too, then it looks us the user agent string in this file to determine if it's a crawler.

  As you may guess, this takes a while the first time it fetches and caches the file, but subsequent checks, once it has the cached copy, are really fast.

  phpbrowscap also self-updates the cache too, so it will always be up-to-date.

  The disadvantage of the overhead on a very occasional request (which may be a bot you don't care about anyway) is outweighed by the advantage of having a more robust test to ensure the filter is not applied to any bots, since the alternative methods (see below) have room for error in that you may not come up with a list of strings to correctly match all the user agents you intended to target.

# Using `contains`

  Add a list of strings to the `allowed_user_agents.strings` config setting and if the user agent contains one of these strings, the age gate will not be applied.

# Using `exact`

  Add a list of strings to the `allowed_user_agents.strings` config setting and if the user agent exactly matches one of these strings, the age gate will not be applied.