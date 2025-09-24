@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p><a href="{{ route('password.redefinePasswordPage', [$user->token]) }}">Clique aqui</a> para redefinir sua senha.</p>
@endsection
