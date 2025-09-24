@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('news.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'news.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.news.form')
		{!! Form::close() !!}
	</div>

@endsection
