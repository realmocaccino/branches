@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('subscriptions.index') !!}</p>
		</div>
		{!! Form::open(['route' => 'subscriptions.store', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.subscriptions.form')
		{!! Form::close() !!}
	</div>

@endsection