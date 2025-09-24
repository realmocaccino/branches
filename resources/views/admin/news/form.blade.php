{!! Form::text('title', ['label' => 'Título', 'placeholder' => 'Insira o título da novidade']) !!}

{!! Form::editor('text', ['label' => 'Texto', 'placeholder' => 'Escreva sobre a novidade', 'height' => '300px']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
