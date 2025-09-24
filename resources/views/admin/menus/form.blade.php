{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome do menu']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
