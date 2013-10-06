<?php

use Carbon\Carbon;

/**
 * Class LaravelAgegateFilter
 *
 * A Laravel Agegate Filter
 */
class LaravelAgegateFilter {

	public function filter()
	{
		if (!Cookie::get('old_enough'))
		{
			Session::flash('url.intended', Request::url());
			return Redirect::to(Config::get('laravel-agegate::agegate_uri'));
		}
	}

}