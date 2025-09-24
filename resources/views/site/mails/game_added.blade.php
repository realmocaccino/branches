@extends('common.layouts.mail.index')

@section('content')
	<p><a href="{{ route('game.index', [$game->slug]) }}">{{ $game->name }}</a> foi cadastrado pelo usuário {{ $user->name }}.</p>
@endsection
