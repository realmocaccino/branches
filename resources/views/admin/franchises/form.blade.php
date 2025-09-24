{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome da franquia']) !!}

{!! Form::text('alias', ['label' => 'Apelido', 'placeholder' => 'A franquia tem algum apelido?']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
