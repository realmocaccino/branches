@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('themes.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'themes.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.themes.form')
		{!! Form::close() !!}
	</div>

@endsection
