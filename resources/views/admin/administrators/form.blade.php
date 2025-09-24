{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome']) !!}

{!! Form::text('email', ['label' => 'Email', 'placeholder' => 'Insira o email']) !!}

@if(Route::currentRouteName() == 'administrators.create')

	{!! Form::password('password', ['label' => 'Senha', 'placeholder' => 'Crie uma senha']) !!}

	{!! Form::password('password_confirmation', ['label' => 'Confirme', 'placeholder' => 'Confirme a senha']) !!}

@endif

{!! Form::select('role_id', $roles, ['label' => 'Papel', 'placeholder' => 'Designe um papel']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
