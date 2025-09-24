@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div class="pull-right">{!! Admin::button('account.edit_password', 'Alterar Senha') !!}</div>
			{!! Admin::showMessage() !!}
			{!! Admin::createMessage('info', 'Última atualização em '.$account->extensive_updated_at) !!}
		</div>
		{!! Form::model($account, ['route' => ['account.update', $account->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira seu nome']) !!}
			{!! Form::email('email', ['label' => 'Email', 'placeholder' => 'Insira seu email']) !!}
			{!! Form::submit('Atualizar', ['class' => 'btn-success']) !!}
		{!! Form::close() !!}
	</div>

@endsection
