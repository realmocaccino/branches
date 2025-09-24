@extends('site.layouts.internal.index', [
	'smaller' => true
])

@section('internal_content')
	
	<p id="internal-descriptive">@lang('password/forgot_password.description')</p>
	
	@component('site.components.form.forgot_password')
	@endcomponent

@endsection
