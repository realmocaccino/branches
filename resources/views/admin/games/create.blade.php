@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('games.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'games.store', 'id' => 'formulario', 'class' => 'form-horizontal', 'files' => true]) !!}
			@include('admin.games.form')
		{!! Form::close() !!}
	</div>

@endsection
