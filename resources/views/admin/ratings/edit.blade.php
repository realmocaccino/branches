@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('ratings.index') !!}</p>
		</div>
		{!! Form::model($rating, ['route' => ['ratings.update', $rating->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			{!! Form::select('game_id', $games, ['label' => 'Jogo', 'placeholder' => 'Selecione o jogo']) !!}
			{!! Form::select('platform_id', $platforms, ['label' => 'Plataforma', 'placeholder' => 'Selecione a plataforma']) !!}
			{!! Form::select('user_id', $users, ['label' => 'Usuário', 'placeholder' => 'Selecione o usuário']) !!}
			{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
		{!! Form::close() !!}
	</div>

@endsection
