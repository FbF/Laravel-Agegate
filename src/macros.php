<?php

Form::macro('html5date', function($name, $value = null, $options = array()) {
    $input =  '<input type="date" name="' . $name . '" value="' . $value . '"';

    foreach ($options as $key => $value) {
        $input .= ' ' . $key . '="' . $value . '"';
    }

    $input .= '>';

    return $input;
});

Form::macro('selectsdate', function($name, $value = null, $options = array()) {

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
				foreach (range(1,31) as $num)
				{
					$input .= '<option value="' . str_pad($num, 2, '0', STR_PAD_LEFT) . '">' . $num . '</option>';
				}
				$input .= '</select>';
				break;
			case 'm':
				$input .= '<select name="' . $name . '_month">';
				foreach (range(1,12) as $num)
				{
					$input .= '<option value="' . str_pad($num, 2, '0', STR_PAD_LEFT) . '">' . $num . '</option>';
				}
				$input .= '</select>';
				break;
			case 'y':
				$input .= '<select name="' . $name . '_year">';
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
					$input .= '<option value="' . $num . '">' . $num . '</option>';
				}
				$input .= '</select>';
				break;
		}
	}

    return $input;
});