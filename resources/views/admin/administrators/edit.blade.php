@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('administrators.index') !!}</p>
		</div>
		{!! Form::model($administrator, ['route' => ['administrators.update', $administrator->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.administrators.form')
		{!! Form::close() !!}
	</div>

@endsection
