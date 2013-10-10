<?php namespace Fbf\LaravelAgegate;

use \Carbon\Carbon;

class AgegateController extends \Illuminate\Routing\Controllers\Controller {

	/**
	 * Renders the age gate view
	 */
	public function agegate()
	{
		\Session::keep('url.intended');
		return \View::make('laravel-agegate::agegate');
	}

	/**
	 * Processes the date of birth submitted in the age gate form
	 */
	public function doAgegate()
	{
		// Get eh date of birth that the user submitted
		$dob = null;
		if (\Input::has('dob'))
		{ // field name is dob when using input type date
			$dob = \Input::get('dob');
		}
		elseif (\Input::has('dob_year') && \Input::has('dob_month') && \Input::has('dob_day'))
		{ // field name has _year, _month and _day components if input type select
			$dob = \Input::get('dob_year').'-'.\Input::get('dob_month').'-'.\Input::get('dob_day');
		}

		$maxDob = Carbon::now()->subYears(\Config::get('laravel-agegate::minimum_age'))->toDateString();

		$validator = \Validator::make(
		    array('dob' => $dob),
		    array('dob' => 'required|date|date_format:Y-m-d|before:'.$maxDob),
		    \Lang::get('laravel-agegate::validation.custom')
		);

		if ($validator->fails())
		{
			\Session::keep('url.intended');
		    return \Redirect::action('Fbf\LaravelAgegate\AgegateController@agegate')->withErrors($validator)->withInput();
		}

		// Set a forever cookie saying the user is old enough
		$cookie = \Cookie::forever(\Config::get('laravel-agegate::cookie_name'), \Config::get('laravel-agegate::cookie_val'));
		return \Redirect::intended('/')->withCookie($cookie);
	}

}