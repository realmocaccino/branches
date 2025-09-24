@extends('site.layouts.internal.index')

@section('internal_content')
	
	@component('site.components.form.account.edit.index', [
		'user' => $user,
		'platforms' => $platforms
	])
	@endcomponent

@endsection