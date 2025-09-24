{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome do jogo']) !!}

{!! Form::text('alias', ['label' => 'Apelido', 'placeholder' => 'O jogo tem algum apelido?']) !!}

{!! Form::textarea('description', ['label' => 'Descrição', 'placeholder' => 'Redija uma descrição para o jogo', 'rows' => 3]) !!}

{!! Form::text('release', ['label' => 'Lançamento', 'placeholder' => 'Insira a data de lançamento'], '00/00/0000') !!}

{!! Form::checkbox('is_early_access', 1, ['label' => 'Jogo está em acesso antecipado']) !!}

{!! Form::select2('franchises', $franchises, ['label' => 'Franquia(s)', 'placeholder' => 'Digite os nomes das franquias']) !!}

{!! Form::select2('genres', $genres, ['label' => 'Gênero(s)', 'placeholder' => 'Digite os nomes dos gêneros']) !!}

{!! Form::select2('characteristics', $characteristics, ['label' => 'Característica(s)', 'placeholder' => 'Digite os nomes das características']) !!}

{!! Form::select2('themes', $themes, ['label' => 'Tema(s)', 'placeholder' => 'Digite os nomes dos temas']) !!}

{!! Form::select2('developers', $developers, ['label' => 'Desenvolvedora(s)', 'placeholder' => 'Digite os nomes das desenvolvedoras']) !!}

{!! Form::select2('publishers', $publishers, ['label' => 'Publicadora(s)', 'placeholder' => 'Digite os nomes das publicadoras']) !!}

{!! Form::select2('platforms', $platforms, ['label' => 'Plataforma(s)', 'placeholder' => 'Digite os nomes das plataformas']) !!}

{!! Form::multipleCheckbox('criterias', $criterias, ['label' => 'Critério(s)']) !!}

{!! Form::multipleCheckbox('modes', $modes, ['label' => 'Modo(s)']) !!}

{!! Form::select('classification_id', $classifications, ['label' => 'Classificação Etária', 'placeholder' => 'Indique a faixa etária do jogo']) !!}

{!! Form::file('cover', ['label' => 'Capa', 'placeholder' => 'Procurar...'], [
	'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
	'initialPreview' => (isset($game) ? $game->getCover('150x185', false) : null),
	'maxFileSize' => 1000,
	'minImageHeight' => 250,
	'minImageWidth' => 250,
]) !!}

{!! Form::file('background', ['label' => 'Imagem de Fundo', 'placeholder' => 'Procurar...'], [
	'allowedFileExtensions' => ['jpg', 'jpeg', 'png'],
	'initialPreview' => (isset($game) ? $game->getBackground() : null),
	'maxFileSize' => 1000,
	'minImageHeight' => 1080,
	'minImageWidth' => 1920,
]) !!}

{!! Form::text('trailer', ['label' => 'Trailer', 'placeholder' => 'Insira a id do vídeo do Youtube']) !!}

{!! Form::text('affiliate_link', ['label' => 'Link de Afiliado', 'placeholder' => 'Insira a URL do link do programa de afiliados']) !!}

{!! Form::textarea('affiliate_iframe', ['label' => 'Iframe de Afiliado', 'placeholder' => 'Insira o código do iframe do programa de afiliados', 'rows' => 2]) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}