@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('news.index') !!}</p>
		</div>
		{!! Form::model($new, ['route' => ['news.update', $new->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.news.form')
		{!! Form::close() !!}
	</div>

@endsection
