@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
		</div>
		{!! Admin::createMessage('warning', 'Página não encontrada') !!}
	</div>

@endsection
