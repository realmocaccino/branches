@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('platforms.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'platforms.store', 'id' => 'formulario', 'class' => 'form-horizontal', 'files' => true]) !!}
			@include('admin.platforms.form')
		{!! Form::close() !!}
	</div>

@endsection
