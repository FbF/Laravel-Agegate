{{ Form::open() }}
    {{ Form::date('dob', Input::old('dob', array('placeholder' => trans('laravel-agegate::content.placeholder')))) }}
    {{ Form::submit() }}
{{ Form::close() }}

@if ($errors->has('dob'))
	{{ $errors->first('dob') }}
@endif