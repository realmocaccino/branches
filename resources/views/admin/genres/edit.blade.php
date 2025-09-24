@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('genres.index') !!}</p>
		</div>
		{!! Form::model($genre, ['route' => ['genres.update', $genre->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.genres.form')
		{!! Form::close() !!}
	</div>

@endsection
