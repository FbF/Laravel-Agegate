<?php namespace Fbf\LaravelAgegate;

/**
 * Class LaravelAgegateFilter
 *
 * A Laravel Agegate Filter
 */
class LaravelAgegateFilter {

	public function filter()
	{
		$cookieVal = \Cookie::get(\Config::get('laravel-agegate::cookie_name'));
		if ($cookieVal != \Config::get('laravel-agegate::cookie_val'))
		{
			\Session::flash('url.intended', \Request::url());
			return \Redirect::action('Fbf\LaravelAgegate\AgegateController@agegate');
		}
	}

}