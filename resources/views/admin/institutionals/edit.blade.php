@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('institutionals.index') !!}</p>
		</div>
		{!! Form::model($institutional, ['route' => ['institutionals.update', $institutional->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.institutionals.form')
		{!! Form::close() !!}
	</div>

@endsection
