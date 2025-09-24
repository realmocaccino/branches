@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}.</p>
	<p>{!! $text !!}.</p>
	<p>Obrigado pela contribuição!</p>
@endsection
