<?php namespace Fbf\LaravelAgegate;

/**
 * Class LaravelAgegateFilter
 *
 * A Laravel Agegate Filter
 */
class LaravelAgegateFilter {

	public function filter()
	{
		if (!$this->isAllowed())
		{
			$this->rememberDesiredUrl();
			return $this->getAgeGateRedirect();
		}
	}

	public function isAllowed()
	{
		if ($this->isAgeCookieOK())
		{
			return true;
		}
		if ($this->isUserAgentAllowed())
		{
			return true;
		}
	}

	public function isAgeCookieOK()
	{
		$cookieVal = \Cookie::get(\Config::get('laravel-agegate::cookie_name'));
		$whatItShouldBe = \Config::get('laravel-agegate::cookie_val');
		return $cookieVal == $whatItShouldBe;
	}

	public function isUserAgentAllowed()
	{
		$allowedUserAgentsMode = \Config::get('laravel-agegate::allowed_user_agents.mode');
		switch ($allowedUserAgentsMode) {
			case 'phpbrowscap_crawler':
				return $this->phpbrowscapIsCrawler();
			case 'contains':
				return $this->userAgentContainsAllowedString();
			case 'exact':
				return $this->userAgentIsAllowedString();
			case 'none':
			default:
				return false;
		}
	}

	public function phpbrowscapIsCrawler()
	{
		// Create a new Browscap object (loads or creates the cache)
		$bc = new \phpbrowscap\Browscap(storage_path('cache'));

		// Get information about the current browser's user agent
		$browser = $bc->getBrowser();

		return $browser->Crawler;
	}

	public function userAgentContainsAllowedString()
	{
		$strings = $this->getAllowedUserAgentStrings();
		$escape = function(&$val)
		{
			$val = preg_quote($val, '/');
		};
		array_walk($strings, $escape);
		$pattern = '/'.implode('|', $strings).'/';
		$userAgent = $this->getLowerUserAgent();
		return preg_match($pattern, $userAgent);
	}

	public function getAllowedUserAgentStrings()
	{
		return \Config::get('laravel-agegate::allowed_user_agents.strings');
	}

	public function getLowerUserAgent()
	{
		return strtolower($_SERVER['HTTP_USER_AGENT']);
	}

	public function userAgentIsAllowedString()
	{
		$strings = $this->getAllowedUserAgentStrings();
		$strings = array_map('strtolower', $strings);
		$userAgent = $this->getLowerUserAgent();
		return in_array($userAgent, $strings);
	}

	public function rememberDesiredUrl()
	{
		$desiredUrl = \Request::fullUrl();
		\Session::flash('url.intended', $desiredUrl);
	}

	public function getAgeGateRedirect()
	{
	    return \Redirect::to(\Config::get('laravel-agegate::agegate_uri').'?'.$_SERVER['QUERY_STRING']);
	}

}