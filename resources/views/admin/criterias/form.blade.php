{!! Form::text('name_pt', ['label' => 'Nome', 'placeholder' => 'Insira o nome do critério de avaliação']) !!}

{!! Form::text('name_en', ['label' => 'Name', 'placeholder' => 'Enter the name of the evaluation critera']) !!}

{!! Form::text('name_es', ['label' => 'Nombre', 'placeholder' => 'Ingrese el nombre del criterio de evaluación']) !!}

{!! Form::text('name_fr', ['label' => 'Nom', 'placeholder' => "Entrez le nom du critère d'évaluation"]) !!}

{!! Form::text('alternative_name_pt', ['label' => 'Nome Alternativo', 'placeholder' => '(opcional) Nome alternativo']) !!}

{!! Form::text('alternative_name_en', ['label' => 'Alternate Name', 'placeholder' => '(opcional) Alternate name']) !!}

{!! Form::text('alternative_name_es', ['label' => 'Nombre Alternativo', 'placeholder' => '(opcional) Nombre alternativo']) !!}

{!! Form::text('alternative_name_fr', ['label' => 'Nom Alternatif', 'placeholder' => '(opcional) Nom alternatif']) !!}

{!! Form::text('description_pt', ['label' => 'Descrição', 'placeholder' => 'Crie uma descrição para o critério']) !!}

{!! Form::text('description_en', ['label' => 'Description', 'placeholder' => 'Create a description to the criteria']) !!}

{!! Form::text('description_es', ['label' => 'Descripción', 'placeholder' => 'Crear una descripción para el criterio']) !!}

{!! Form::text('description_fr', ['label' => 'Description', 'placeholder' => 'Créer une description du critère']) !!}

{!! Form::number('weight', ['label' => 'Peso', 'min' => 1, 'max' => 5, 'step' => 0.5]) !!}

{!! Form::select('order', array_combine(range(1, $total_criterias), range(1, $total_criterias)), ['label' => 'Ordem', 'placeholder' => 'Selecione a ordem do critério']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
