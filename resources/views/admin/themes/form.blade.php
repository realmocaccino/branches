{!! Form::text('name_pt', ['label' => 'Nome', 'placeholder' => 'Insira o nome do tema']) !!}

{!! Form::text('name_en', ['label' => 'Name', 'placeholder' => 'Enter the name of the theme']) !!}

{!! Form::text('name_es', ['label' => 'Nombre', 'placeholder' => 'Ingrese el nombre del tema']) !!}

{!! Form::text('name_fr', ['label' => 'Nom', 'placeholder' => 'Entrez le nom du thème']) !!}

{!! Form::text('alternative_name_pt', ['label' => 'Nome Alternativo', 'placeholder' => '(opcional) Nome alternativo']) !!}

{!! Form::text('alternative_name_en', ['label' => 'Alternate Name', 'placeholder' => '(opcional) Alternate name']) !!}

{!! Form::text('alternative_name_es', ['label' => 'Nombre Alternativo', 'placeholder' => '(opcional) Nombre alternativo']) !!}

{!! Form::text('alternative_name_fr', ['label' => 'Nom Alternatif', 'placeholder' => '(opcional) Nom alternatif']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
