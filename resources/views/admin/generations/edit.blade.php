@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('generations.index') !!}</p>
		</div>
		{!! Form::model($generation, ['route' => ['generations.update', $generation->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.generations.form')
		{!! Form::close() !!}
	</div>

@endsection
