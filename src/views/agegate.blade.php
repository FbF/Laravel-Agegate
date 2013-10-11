{{ Form::open() }}
    {{ Form::agegatedate('dob', Input::old(), array('format' => 'dmy')) }}
    {{ Form::submit(trans('laravel-agegate::content.submit')) }}
{{ Form::close() }}
@if ($errors->has('dob'))
	{{ $errors->first('dob') }}
@endif