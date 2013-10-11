<?php

return array(

	/**
	 * The URI of the agegate
	 */
	'agegate_uri' => 'agegate',

	/**
	 * The minimum age to access the site
	 */
	'minimum_age' => 18,

	/**
	 * The input type to use. Choices are:
	 * "date" for html5 <input type="date" />
	 * "select" for 3 <select> tags for day, month and year
	 */
	'input_type' => 'select',

	/**
	 * The name of the cookie to set. Change this to whatever you want
	 */
	'cookie_name' => 'age_ok',

	/**
	 * The value of the cookie to set. Change this to something unique
	 */
	'cookie_val' => 'hell yeah!',

	/**
	 * The view that should be rendered for the agegate. You can use the bundled view, or specify your own and use
	 * @include('laravel-agegate::agegate') to get the agegate form and validation errors
	 */
	'view' => 'laravel-agegate::agegate',


);