{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome da plataforma']) !!}

{!! Form::text('initials', ['label' => 'Sigla', 'placeholder' => 'Crie uma sigla para a plataforma']) !!}

{!! Form::select('manufacturer_id', $manufacturers, ['label' => 'Fabricante', 'placeholder' => 'Selecione o fabricante']) !!}

{!! Form::text('release', ['label' => 'Lançamento', 'placeholder' => 'Insira o ano de lançamento'], '0000') !!}

{!! Form::select('generation_id', $generations, ['label' => 'Geração', 'placeholder' => 'Selecione a geração da plataforma']) !!}

{!! Form::file('logo', ['label' => 'Logo', 'placeholder' => 'Procurar...'], [
	'allowedFileExtensions' => ['png'],
	'initialPreview' => (isset($platform) ? $platform->getLogo() : null),
	'maxFileSize' => 60,
	'minImageHeight' => 64,
	'minImageWidth' => 64,
]) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
