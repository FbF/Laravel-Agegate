<?php namespace Fbf\LaravelAgegate;

/**
 * Class LaravelAgegateFilter
 *
 * A Laravel Agegate Filter
 */
class LaravelAgegateFilter {

	public function filter()
	{
		if (!\Cookie::get('old_enough'))
		{
			\Session::flash('url.intended', \Request::url());
			return \Redirect::action('Fbf\LaravelAgegate\AgegateController@agegate');
		}
	}

}