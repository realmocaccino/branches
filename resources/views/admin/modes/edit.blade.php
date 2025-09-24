@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('modes.index') !!}</p>
		</div>
		{!! Form::model($mode, ['route' => ['modes.update', $mode->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.modes.form')
		{!! Form::close() !!}
	</div>

@endsection
