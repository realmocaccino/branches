@extends('site.layouts.internal.index', [
	'smaller' => true
])

@section('internal_content')
	
	@component('site.components.social.login')@endcomponent
	@component('site.components.form.login')@endcomponent
	@component('site.components.strike', [
		'text' => trans('login/index.or_text')
	])
	@endcomponent
	<a href="{{ route('register.index') }}" class="btn btn-block btn-success">@lang('login/index.or_button_text')</a>

@endsection