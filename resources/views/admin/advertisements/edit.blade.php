@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('advertisements.index') !!}</p>
		</div>
		{!! Form::model($advertisement, ['route' => ['advertisements.update', $advertisement->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.advertisements.form')
		{!! Form::close() !!}
	</div>

@endsection
