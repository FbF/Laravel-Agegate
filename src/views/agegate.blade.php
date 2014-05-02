{{ Form::open() }}
    {{ Form::agegatedate('dob', Input::old(), array('format' => 'dmy', 'disabled' => $previousTooYoung)) }}
    {{ Form::submit(trans('laravel-agegate::content.submit'), array('disabled' => $previousTooYoung)) }}
{{ Form::close() }}
@if ($errors->has('dob'))
	{{ $errors->first('dob') }}
@endif