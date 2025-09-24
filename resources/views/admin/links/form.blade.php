{!! Form::select('menu_id', $menus, ['label' => 'Menu', 'placeholder' => 'Selecione o menu do link']) !!}

{!! Form::text('name_pt', ['label' => 'Nome', 'placeholder' => 'Insira o nome do link']) !!}

{!! Form::text('name_en', ['label' => 'Name', 'placeholder' => 'Enter the name of the link']) !!}

{!! Form::text('name_es', ['label' => 'Nombre', 'placeholder' => 'Ingrese el nombre del enlace']) !!}

{!! Form::text('name_fr', ['label' => 'Nom', 'placeholder' => 'Entrez le nom du lien']) !!}

{!! Form::text('route', ['label' => 'Rota', 'placeholder' => 'Insira a rota do link']) !!}

{!! Form::text('parameters', ['label' => 'Parâmetros', 'placeholder' => 'Insira os parâmetros da rota separados por vírgula']) !!}

{!! Form::select('target', $targets, ['label' => 'Alvo', 'placeholder' => 'Escolha como abrir o link']) !!}

{!! Form::select('order', array_combine(range(1, 20), range(1, 20)), ['label' => 'Ordem', 'placeholder' => 'Selecione a ordem do link no menu']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}
	
{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
