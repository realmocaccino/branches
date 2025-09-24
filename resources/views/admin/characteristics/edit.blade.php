@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('characteristics.index') !!}</p>
		</div>
		{!! Form::model($characteristic, ['route' => ['characteristics.update', $characteristic->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.characteristics.form')
		{!! Form::close() !!}
	</div>

@endsection
