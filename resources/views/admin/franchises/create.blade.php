@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('franchises.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'franchises.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.franchises.form')
		{!! Form::close() !!}
	</div>

@endsection
