{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome da classificação indicativa']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
