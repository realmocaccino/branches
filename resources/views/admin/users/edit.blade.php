@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('users.index') !!}</p>
		</div>
		{!! Form::model($user, ['route' => ['users.update', $user->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome do usuário']) !!}
			{!! Form::text('slug', ['label' => 'Slug', 'placeholder' => 'Crie um slug para o usuário']) !!}
			{!! Form::email('email', ['label' => 'Email', 'placeholder' => 'Insira o email do usuário']) !!}
			{!! Form::checkbox('newsletter', 1, ['label' => 'Inscrito nas newsletters']) !!}
			{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}
			{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
		{!! Form::close() !!}
	</div>

@endsection
