{!! Form::text('slug', ['label' => 'URL', 'placeholder' => 'Insira a URL da página de contato']) !!}

{!! Form::text('title_pt', ['label' => 'Título', 'placeholder' => 'Insira o título da página de contato']) !!}

{!! Form::text('title_en', ['label' => 'Title', 'placeholder' => 'Enter the title of the contact page']) !!}

{!! Form::text('title_es', ['label' => 'Titulo', 'placeholder' => 'Ingrese el título de la página de contato']) !!}

{!! Form::text('title_fr', ['label' => 'Titre', 'placeholder' => 'Entrez le titre de la page de contact']) !!}

{!! Form::textarea('description_pt', ['label' => 'Descrição', 'placeholder' => 'Insira a descrição da página de contato', 'rows' => '3']) !!}

{!! Form::textarea('description_en', ['label' => 'Description', 'placeholder' => 'Enter the description of the contact page', 'rows' => '3']) !!}

{!! Form::textarea('description_es', ['label' => 'Descripción', 'placeholder' => 'Ingrese la descripción de la página de contato', 'rows' => '3']) !!}

{!! Form::textarea('description_fr', ['label' => 'Description', 'placeholder' => 'Entrez la description de la page de contact', 'rows' => '3']) !!}

{!! Form::email('email', ['label' => 'Email', 'placeholder' => 'Insira o email para contato']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
