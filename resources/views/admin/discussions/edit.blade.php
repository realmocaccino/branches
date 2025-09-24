@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('discussions.index') !!}</p>
		</div>
		{!! Form::model($discussion, ['route' => ['discussions.update', $discussion->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.discussions.form')
		{!! Form::close() !!}
	</div>

@endsection