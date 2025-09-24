@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('advertisements.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'advertisements.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.advertisements.form')
		{!! Form::close() !!}
	</div>

@endsection
