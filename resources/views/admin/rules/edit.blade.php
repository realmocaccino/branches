@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('rules.index') !!}</p>
		</div>
		{!! Form::model($rule, ['route' => ['rules.update', $rule->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.rules.form')
		{!! Form::close() !!}
	</div>

@endsection
