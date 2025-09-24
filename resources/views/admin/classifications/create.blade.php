@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('classifications.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'classifications.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.classifications.form')
		{!! Form::close() !!}
	</div>

@endsection
