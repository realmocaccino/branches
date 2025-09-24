@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('platforms.index') !!}</p>
		</div>
		{!! Form::model($platform, ['route' => ['platforms.update', $platform->id], 'id' => 'formulario', 'class' => 'form-horizontal', 'files' => true]) !!}
			@include('admin.platforms.form')
		{!! Form::close() !!}
	</div>

@endsection
