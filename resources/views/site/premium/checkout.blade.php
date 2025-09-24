@extends('site.layouts.main.index')

@section('content')

    <div id="premium-checkout">
        @include('site.components.premium.checkout.plan')
        @include('site.components.premium.checkout.form')
    </div>

@endsection