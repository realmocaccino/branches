@extends('common.layouts.mail.index')

@section('content')
	<p><strong>Nome:</strong> {{ $request['name'] }}</p>
	<p><strong>Email:</strong> {{ $request['email'] }}</p>
	<p><strong>Mensagem</strong></p>
	<p>{!! nl2br($request['message']) !!}</p>
@endsection
