@extends('site.layouts.main.index')

@section('content')

    <div class="container">
	    <div class="row" id="error">
            <div class="col-12">
	            <img id="error-image" src="{{ asset('img/error/' . $code . '.png') }}" alt="=/">
	            <p id="error-message">{{ $message }}</p>
            </div>
	    </div>
    </div>

@endsection