@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('manufacturers.index') !!}</p>
		</div>
		{!! Form::model($manufacturer, ['route' => ['manufacturers.update', $manufacturer->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.manufacturers.form')
		{!! Form::close() !!}
	</div>

@endsection
