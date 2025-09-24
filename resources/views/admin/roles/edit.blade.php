@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('roles.index') !!}</p>
		</div>
		{!! Form::model($role, ['route' => ['roles.update', $role->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.roles.form')
		{!! Form::close() !!}
	</div>

@endsection
