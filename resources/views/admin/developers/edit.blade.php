@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('developers.index') !!}</p>
		</div>
		{!! Form::model($developer, ['route' => ['developers.update', $developer->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.developers.form')
		{!! Form::close() !!}
	</div>

@endsection
