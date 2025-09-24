@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('developers.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'developers.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.developers.form')
		{!! Form::close() !!}
	</div>

@endsection
