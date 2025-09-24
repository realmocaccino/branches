@extends('common.layouts.mail.index')

@section('content')
	<p>Olá {{ $user->name }}!</p>
	<p>{!! $text !!}.</p>
	<p>Não é algo que você deva se preocupar, mas vale tirar um tempo para ler pois os termos servem para o bem da própria comunidade =)</p>
@endsection
