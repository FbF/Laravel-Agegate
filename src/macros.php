<?php

Form::macro('date', function($name, $value = null, $options = array()) {
    $input =  '<input type="date" name="' . $name . '" value="' . $value . '"';

    foreach ($options as $key => $value) {
        $input .= ' ' . $key . '="' . $value . '"';
    }

    $input .= '>';

    return $input;
});