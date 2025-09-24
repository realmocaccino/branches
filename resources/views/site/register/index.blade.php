@extends('site.layouts.internal.index', [
	'smaller' => true
])

@section('internal_content')
	
	@component('site.components.social.login')@endcomponent
	@component('site.components.form.register')@endcomponent
	@component('site.components.strike', [
		'text' => trans('register/index.or_text')
	])
	@endcomponent
	<a href="{{ route('login.index') }}" class="btn btn-block btn-primary">@lang('register/index.or_button_text')</a>
	
@endsection
