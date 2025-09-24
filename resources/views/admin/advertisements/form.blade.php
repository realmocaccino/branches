{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Insira o nome do anúncio']) !!}

{!! Form::select('advertiser_id', $advertisers, ['label' => 'Anunciante', 'placeholder' => 'Selecione o anunciante']) !!}

{!! Form::textarea('analytics', ['label' => 'Código', 'placeholder' => 'Cole o código aqui', 'rows' => 4]) !!}

{!! Form::select('platform', $platforms, ['label' => 'Plataforma', 'plaeholder' => 'Selecione a plataforma']) !!}

{!! Form::checkbox('responsive', 1, ['label' => 'Dimensão responsiva']) !!}

{!! Form::text('width', ['label' => 'Largura', 'placeholder' => 'Digite a largura do anúncio']) !!}

{!! Form::text('height', ['label' => 'Altura', 'placeholder' => 'Digite a altura do anúncio']) !!}

{!! Form::text('style', ['label' => 'Estilo', 'placeholder' => 'Insira os estilos do anúncio']) !!}

{!! Form::switcher('status', 1, ['label' => 'Status'], ['Online', 'Offline']) !!}

{!! Form::submit('Concluir', ['class' => 'btn-success']) !!}
