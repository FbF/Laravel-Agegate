{{ Form::open() }}
    {{ Form::date('dob') }}
    {{ Form::submit() }}
{{ Form::close() }}

@if ($errors->has('dob'))
	{{ $errors->first('dob') }}
@endif