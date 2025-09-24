@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('genres.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'genres.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.genres.form')
		{!! Form::close() !!}
	</div>

@endsection
