@extends('common.layouts.mail.index')

@section('content')
	<p>Nova solicitação de edição de {{ $modelName }}</p>
	<p>{{ $entityName }}</p>
	<p><em>por</em> {{ $user->name }}</p>
@endsection
