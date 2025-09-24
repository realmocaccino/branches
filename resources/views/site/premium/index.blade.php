@extends('site.layouts.main.index')

@section('content')
	
	<div id="premium">
	    @include('site.components.premium.index.header')
	    <p id="premium-text">@lang('premium/index.text')</p>
	    <hr>
	    @include('site.components.premium.index.buttons')
		@include('site.components.premium.index.image')
		@include('site.components.premium.index.users')
	    @include('site.components.premium.index.benefits')
	    @include('site.components.premium.index.buttons')
	</div>
	
@endsection