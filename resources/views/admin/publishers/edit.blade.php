@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('publishers.index') !!}</p>
		</div>
		{!! Form::model($publisher, ['route' => ['publishers.update', $publisher->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.publishers.form')
		{!! Form::close() !!}
	</div>

@endsection
