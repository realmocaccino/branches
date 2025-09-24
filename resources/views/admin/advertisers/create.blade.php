@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('advertisers.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'advertisers.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.advertisers.form')
		{!! Form::close() !!}
	</div>

@endsection
