@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('manufacturers.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'manufacturers.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.manufacturers.form')
		{!! Form::close() !!}
	</div>

@endsection
