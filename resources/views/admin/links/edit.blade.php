@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('links.index') !!}</p>
		</div>
		{!! Form::model($link, ['route' => ['links.update', $link->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.links.form')
		{!! Form::close() !!}
	</div>

@endsection
