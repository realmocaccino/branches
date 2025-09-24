@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('reviews.index') !!}</p>
		</div>
		{!! Form::model($review, ['route' => ['reviews.update', $review->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			{!! Form::textarea('text', ['label' => 'Texto', 'placeholder' => 'Redija uma texto para a análise']) !!}
			{!! Form::checkbox('has_spoilers', 1, ['label' => 'Análise contêm spoilers?']) !!}
			{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
		{!! Form::close() !!}
	</div>

@endsection
