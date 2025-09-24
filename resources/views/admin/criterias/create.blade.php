@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('criterias.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'criterias.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.criterias.form')
		{!! Form::close() !!}
	</div>

@endsection
