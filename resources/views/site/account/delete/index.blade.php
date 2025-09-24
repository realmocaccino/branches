@extends('site.layouts.internal.index')

@section('internal_content')
	
	<p id="internal-descriptive">@lang('account/delete/index.are_you_sure') {{ $settings->name }} @lang('account/delete/index.as_well_ratings_and_reviews')</p>
	
	@component('site.components.form.account.delete.index', [
		'user' => $user
	])
	@endcomponent

@endsection