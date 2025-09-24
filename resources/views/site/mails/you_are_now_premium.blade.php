@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p>{!! $text !!} no <a href="{{ route('home') }}"><strong>{{ $settings->name }}</strong></a></p>
@endsection