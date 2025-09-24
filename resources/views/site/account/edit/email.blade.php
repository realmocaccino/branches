@extends('site.layouts.internal.index')

@section('internal_content')
	
	@component('site.components.form.account.edit.email', [
		'user' => $user
	])
	@endcomponent

@endsection