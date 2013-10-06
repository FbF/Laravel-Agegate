<?php

use Carbon\Carbon;

Route::get(Config::get('laravel-agegate::agegate_uri'), function()
{
	Session::keep('url.intended');
	return View::make('laravel-agegate::agegate');
});

Route::post(Config::get('laravel-agegate::agegate_uri'), array('before' => 'csrf', function()
{
	$maxDob = Carbon::now('Europe/London')->subYears(Config::get('laravel-agegate::minimum_age'))->toDateString();
	$validator = Validator::make(
	    array('dob' => Input::get('dob')),
	    array('dob' => 'required|date|date_format:Y-m-d|before:'.$maxDob),
	    Lang::get('laravel-agegate::validation.custom')
	);
	if ($validator->fails())
	{
	    return Redirect::to(Config::get('laravel-agegate::agegate_uri'))->withErrors($validator);
	}
	$cookie = Cookie::forever('old_enough', true);
	return Redirect::intended('/')->withCookie($cookie);
}));
