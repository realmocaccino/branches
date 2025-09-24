@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('plans.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'plans.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.plans.form')
		{!! Form::close() !!}
	</div>

@endsection