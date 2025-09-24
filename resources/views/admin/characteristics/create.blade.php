@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('characteristics.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'characteristics.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.characteristics.form')
		{!! Form::close() !!}
	</div>

@endsection
