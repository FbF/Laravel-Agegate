{{ Form::open() }}
    {{ Form::agegatedate('dob', Input::old(), array('format' => 'dmy')) }}
    {{ Form::submit() }}
{{ Form::close() }}
@if ($errors->has('dob'))
	{{ $errors->first('dob') }}
@endif