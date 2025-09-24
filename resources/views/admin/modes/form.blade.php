{!! Form::text('name_pt', ['label' => 'Nome', 'placeholder' => 'Insira o nome do modo de jogo']) !!}

{!! Form::text('name_en', ['label' => 'Name', 'placeholder' => 'Enter the name of the game mode']) !!}

{!! Form::text('name_es', ['label' => 'Nombre', 'placeholder' => 'Ingrese el nombre del modo de juego']) !!}

{!! Form::text('name_fr', ['label' => 'Nom', 'placeholder' => 'Entrez le nom du mode de jeu']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
