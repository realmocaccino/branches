@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p>{!! $text !!} =/</p>
	<p>Você pode escrever uma nova análise para o mesmo jogo, prestando atenção em não expor spoilers ou algo ofensivo =)</p>
@endsection