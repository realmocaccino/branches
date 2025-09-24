@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p>Confirme sua conta <a href="{{ route('register.confirm', [$user->token]) }}">clicando aqui</a>.</p>
@endsection
