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

	/**
	 *
	 */
	'allowed_user_agents' => array(

		/**
		 * phpbrowscap_crawler|contains|exact|none
		 *
		 * phpbrowscap_crawler - this will use phpbrowscap to determine if the user
		 * agent is a crawler. PLEASE NOTE THAT PHPBROWSCAP LOADS AND STORES A
		 * BROWSCAP.INI FILE INTO YOUR APPLICATION STORAGE DIRECTORY. IT ALSO
		 * CREATES A PHP ARRAY CACHED VERSION OF THE INI FILE FOR PERFORMANCE.
		 * THEREFORE THE FIRST TIME THIS IS RUN, IT TAKES A WHILE TO FETCH AND
		 * PROCESS THE FILE. SUBSEQUENT CALLS ARE MUCH MUCH FASTER. ALSO NOTE
		 * THAT PHPBROWSCAP WILL UPDATE THE CACHE AT REGULAR INTERVALS, SO
		 * OCCASIONALLY REQUESTS WILL TAKE A WHILE AGAIN. IF YOU DON'T WANT TO USE
		 * THIS APPROACH, CHANGE THE allowed_user_agents.mode TO A DIFFERENT SETTING
		 *
		 * contains - this will search the user agent string for any of the strings
		 * listed in the allowed_user_agents.strings array. This is case insensitive.
		 *
		 * exact - this will try to match the user agent string against one of the
		 * strings listed in the allowed_user_agents.strings array. This is case
		 * insensitive.
		 *
		 * none - No user agents are allowed without having passed through the age
		 * gate, and therefore have a cookie.
		 */
		'mode' => 'phpbrowscap_crawler',

		/**
		 * strings for use with mode:contains|exact
		 *
		 * The following are an example of what to use if mode = contains and you
		 * want to allow search engines etc (note, this may or may not cover all
		 * the major search engines, and you may or may not get false positives)
		 *
		 * If mode = exact, the strings should be the full, exact user agents that
		 * you want to allow. E.g. Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)
		 */
		'strings' => array(
			'bot',
			'slurp',
			'crawl',
			'spider',
			'yahoo',
			'facebookexternalhit',
		),

	),

);