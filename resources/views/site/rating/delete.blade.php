@extends('site.layouts.internal.index', [
	'smaller' => true
])

@section('internal_content')
	
	@include('site.components.rating.delete')
	
@endsection
