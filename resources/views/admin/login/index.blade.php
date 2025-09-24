@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			{!! Admin::showMessage() !!}
		</div>
		{!! Form::open(['route' => 'login.authenticate', 'class' => 'form-horizontal']) !!}
			<div class="form-group">
				{!! Form::error('email') !!}
				<label class="control-label col-sm-1" for="email">Email:</label>
				<div class="col-sm-4">
					<input placeholder="Insira seu email" class="form-control" id="email" name="email" type="email" value="{{ old('email') }}">
				</div>
			</div>
			<div class="form-group">
				{!! Form::error('password') !!}
				<label class="control-label col-sm-1" for="password">Senha:</label>
				<div class="col-sm-4">
					<input placeholder="Digite sua senha" class="form-control" id="password" name="password" type="password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-4 col-sm-offset-1">
					<input class="btn-success btn" type="submit" value="Enviar">
				</div>
			</div>
		{!! Form::close() !!}
	</div>

@endsection
