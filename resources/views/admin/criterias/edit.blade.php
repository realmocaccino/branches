@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('criterias.index') !!}</p>
		</div>
		{!! Form::model($criteria, ['route' => ['criterias.update', $criteria->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.criterias.form')
		{!! Form::close() !!}
	</div>

@endsection
