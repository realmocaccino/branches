@extends('site.layouts.internal.index')

@section('internal_content')

	<p id="internal-descriptive">{!! $description !!}</p>

	@component('site.components.form.contact', [
		'routeParameter' => $slug,
		'user' => $user
	])
	@endcomponent

@endsection