@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('account.edit') !!}</div>
		</div>
		{!! Form::model($account, ['route' => ['account.update_password', $account->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			{!! Form::password('password', ['label' => 'Senha', 'placeholder' => 'Crie uma nova senha']) !!}
			{!! Form::password('password_confirmation', ['label' => 'Confirme', 'placeholder' => 'Confirme sua nova senha']) !!}
			{!! Form::submit('Atualizar', ['class' => 'btn-success']) !!}
		{!! Form::close() !!}
	</div>

@endsection
