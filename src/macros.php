<?php

Form::macro('agegatedate', function($name, $value = null, $options = array())
{
	switch (Config::get('laravel-agegate::input_type')) {
		case 'date':
			if (array_key_exists($name, $value))
			{
				$value = $value[$name];
			}
			else
			{
				$value = null;
			}
			return Form::agegatehtml5date($name, $value, $options);
		case 'select':
			$names = array($name.'_year', $name.'_month', $name.'_day');
			$value = array_intersect_key($value, array_flip($names));
			return Form::agegateselectsdate($name, $value, $options);
		default:
			throw new InvalidArgumentException('Invalid configuration option for laravel-agegate::input_type. Must be one of "date", "select"');
	}
});

Form::macro('agegatehtml5date', function($name, $value = null, $options = array()) {
    $input =  '<input type="date" name="' . $name . '" value="' . $value . '"';

    foreach ($options as $key => $value) {
        $input .= ' ' . $key . '="' . $value . '"';
    }

    $input .= '>';

    return $input;
});

Form::macro('agegateselectsdate', function($name, $value = null, $options = array()) {

	$selectedDay   = is_array($value) && array_key_exists($name.'_day',   $value) ? $value[$name.'_day']   : false;
	$selectedMonth = is_array($value) && array_key_exists($name.'_month', $value) ? $value[$name.'_month'] : false;
	$selectedYear  = is_array($value) && array_key_exists($name.'_year',  $value) ? $value[$name.'_year']  : false;

	$format = 'ymd';
	if (array_key_exists('format', $options)
		&& strlen($options['format']) == 3
		&& stripos($options['format'], 'y') !== false
		&& stripos($options['format'], 'm') !== false
		&& stripos($options['format'], 'd') !== false)
	{
		$format = strtolower($options['format']);
	}
	$components = preg_split('//', $format);

	$input = '';

	foreach ($components as $component)
	{
		switch ($component) {
			case 'd':
				$input .= '<select name="' . $name . '_day">';
				$input .= '<option value="">'.trans('dd').'</option>';
				foreach (range(1,31) as $num)
				{
					$num = str_pad($num, 2, '0', STR_PAD_LEFT);
					$input .= '<option value="' . $num . '"';
					if ($num == $selectedDay)
					{
						$input .= ' selected="selected"';
					}
					$input .= '>' . $num . '</option>';
				}
				$input .= '</select>';
				break;
			case 'm':
				$input .= '<select name="' . $name . '_month">';
				$input .= '<option value="">'.trans('mm').'</option>';
				foreach (range(1,12) as $num)
				{
					$num = str_pad($num, 2, '0', STR_PAD_LEFT);
					$input .= '<option value="' . $num . '"';
					if ($num == $selectedMonth)
					{
						$input .= ' selected="selected"';
					}
					$input .= '>' . $num . '</option>';
				}
				$input .= '</select>';
				break;
			case 'y':
				$input .= '<select name="' . $name . '_year">';
				$input .= '<option value="">'.trans('yyyy').'</option>';
				$min = 1900;
				if (array_key_exists('min', $options) && preg_match('/^(\d{4})-\d{2}-\d{2}$/', $options['min'], $matches))
				{
					$min = $matches[1];
				}
				$max = date('Y')+100;
				if (array_key_exists('max', $options) && preg_match('/^(\d{4})-\d{2}-\d{2}$/', $options['max'], $matches))
				{
					$max = $matches[1];
				}
				foreach (range($min, $max) as $num)
				{
					$input .= '<option value="' . $num . '"';
					if ($num == $selectedYear)
					{
						$input .= ' selected="selected"';
					}
					$input .= '>' . $num . '</option>';
				}
				$input .= '</select>';
				break;
		}
	}

    return $input;
});