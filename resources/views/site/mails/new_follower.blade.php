@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p><img src="{{ $follower->getPicture('34x34') }}"> {!! $text !!} no <a href="{{ route('home') }}"><strong>{{ $settings->name }}</strong></a></p>
@endsection