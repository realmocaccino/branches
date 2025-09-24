{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome da geração']) !!}

{!! Form::text('interval', ['label' => 'Intervalo', 'placeholder' => 'Digite o intervalo'], '0000-0000') !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
