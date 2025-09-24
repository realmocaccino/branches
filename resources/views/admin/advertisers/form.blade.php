{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome do gênero']) !!}

{!! Form::text('analytics', ['label' => 'URL de Script', 'placeholder' => 'Insira a url de script do anunciante']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
