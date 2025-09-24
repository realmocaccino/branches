@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('menus.index') !!}</p>
		</div>
		{!! Form::model($menu, ['route' => ['menus.update', $menu->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.menus.form')
		{!! Form::close() !!}
	</div>

@endsection
