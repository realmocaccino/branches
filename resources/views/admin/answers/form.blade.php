{!! Form::textarea('text', ['label' => 'Texto', 'placeholder' => 'Redija um texto para a resposta', 'rows' => 3]) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}