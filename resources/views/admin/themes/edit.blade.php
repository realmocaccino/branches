@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('themes.index') !!}</p>
		</div>
		{!! Form::model($theme, ['route' => ['themes.update', $theme->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.themes.form')
		{!! Form::close() !!}
	</div>

@endsection
