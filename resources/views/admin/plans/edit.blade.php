@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('plans.index') !!}</p>
		</div>
		{!! Form::model($plan, ['route' => ['plans.update', $plan->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.plans.form')
		{!! Form::close() !!}
	</div>

@endsection