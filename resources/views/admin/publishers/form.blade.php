{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome da publicadora']) !!}

{!! Form::text('foundation', ['label' => 'Fundação', 'placeholder' => 'Insira o ano da fundação'], '0000') !!}

{!! Form::text('headquarters', ['label' => 'Sede', 'placeholder' => 'Insira o local da sede']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
