@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('franchises.index') !!}</p>
		</div>
		{!! Form::model($franchise, ['route' => ['franchises.update', $franchise->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.franchises.form')
		{!! Form::close() !!}
	</div>

@endsection
