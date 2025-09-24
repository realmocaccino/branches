{!! Form::text('slug', ['label' => 'URL', 'placeholder' => 'Insira a URL do regulamento']) !!}

{!! Form::text('title', ['label' => 'Título', 'placeholder' => 'Insira o título do regulamento']) !!}

{!! Form::textarea('description', ['label' => 'Descrição', 'placeholder' => 'Insira a descrição do regulamento', 'rows' => '3']) !!}

{!! Form::editor('text', ['label' => 'Texto', 'placeholder' => 'Redija o regulamento', 'height' => '300px']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
