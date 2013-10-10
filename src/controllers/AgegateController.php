<?php namespace Fbf\LaravelAgegate;

use \Carbon\Carbon;

class AgegateController extends \Illuminate\Routing\Controllers\Controller {

	public function agegate()
	{
		\Session::keep('url.intended');
		return \View::make('laravel-agegate::agegate');
	}

	public function doAgegate()
	{
		$dob = null;
		if (\Input::has('dob'))
		{
			$dob = \Input::get('dob');
		}
		elseif (\Input::has('dob_year') && \Input::has('dob_month') && \Input::has('dob_day'))
		{
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
		    return \Redirect::to(\Config::get('laravel-agegate::agegate_uri'))->withErrors($validator);
		}
		$cookie = \Cookie::forever('old_enough', true);
		return \Redirect::intended('/')->withCookie($cookie);
	}

}