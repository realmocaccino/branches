@extends('site.layouts.internal.index', [
	'smaller' => true
])

@section('internal_content')
	
	<p id="internal-descriptive">@lang('password/redefine_password.description')</p>
	
	@component('site.components.form.redefine_password', [
		'token' => $token
	])
	@endcomponent

@endsection
