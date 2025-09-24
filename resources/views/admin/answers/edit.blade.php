@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('answers.index') !!}</p>
		</div>
		{!! Form::model($answer, ['route' => ['answers.update', $answer->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.answers.form')
		{!! Form::close() !!}
	</div>

@endsection