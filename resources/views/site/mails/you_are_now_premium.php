@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p>{!! $text !!}</p>
@endsection