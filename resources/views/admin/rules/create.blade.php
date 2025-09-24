@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('rules.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'rules.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.rules.form')
		{!! Form::close() !!}
	</div>

@endsection
