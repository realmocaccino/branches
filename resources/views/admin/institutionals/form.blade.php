{!! Form::text('slug', ['label' => 'URL', 'placeholder' => 'Insira a URL da página institucional']) !!}

{!! Form::text('title_pt', ['label' => 'Título', 'placeholder' => 'Insira o título da página institucional']) !!}

{!! Form::text('title_en', ['label' => 'Title', 'placeholder' => 'Enter the title of the institutional page']) !!}

{!! Form::text('title_es', ['label' => 'Titulo', 'placeholder' => 'Ingrese el título de la página institucional']) !!}

{!! Form::text('title_fr', ['label' => 'Titre', 'placeholder' => 'Entrez le titre de la page institutionnelle']) !!}

{!! Form::textarea('description_pt', ['label' => 'Descrição', 'placeholder' => 'Insira a descrição da página institucional', 'rows' => '3']) !!}

{!! Form::textarea('description_en', ['label' => 'Description', 'placeholder' => 'Enter the description of the institutional page', 'rows' => '3']) !!}

{!! Form::textarea('description_es', ['label' => 'Descripción', 'placeholder' => 'Ingrese la descripción de la página institucional', 'rows' => '3']) !!}

{!! Form::textarea('description_fr', ['label' => 'Description', 'placeholder' => 'Entrez la description de la page institutionnelle', 'rows' => '3']) !!}

{!! Form::editor('text_pt', ['label' => 'Texto', 'placeholder' => 'Redija o texto institucional', 'height' => '300px']) !!}

{!! Form::editor('text_en', ['label' => 'Text', 'placeholder' => 'Write the institutional text', 'height' => '300px']) !!}

{!! Form::editor('text_es', ['label' => 'Texto', 'placeholder' => 'Escribe el texto institucional', 'height' => '300px']) !!}

{!! Form::editor('text_fr', ['label' => 'Texte', 'placeholder' => 'Rédiger le texte institutionnel', 'height' => '300px']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
