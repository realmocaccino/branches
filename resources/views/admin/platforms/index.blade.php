@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Plataforma') !!}</div>
			<div class="pull-right">{!! Admin::button('platforms.create', 'Criar Plataforma') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$platforms->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="26%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%">{!! Admin::sort('initials', 'Sigla', 'Ordenar por sigla') !!}</th>
						<th width="12%">{!! Admin::sort('release', 'Lançamento', 'Ordenar por ano de lançamento') !!}</th>
						<th width="14%">Geração</th>
						<th width="5%" class="text-center">Jogos</th>
						<th width="5%" class="text-center">Avaliações</th>
						<th width="4%" class="text-center">Status</th>
						<th width="4%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($platforms as $platform)
				<tr>
					<td>{!! Admin::date($platform->extensive_updated_at) !!}</td>
					<td>{{ $platform->name }}</td>
					<td>{{ $platform->initials }}</td>
					<td>{{ $platform->release }}</td>
					<td>@if($platform->generation) {{ $platform->generation->name }} @endif</td>
					<td class="text-center">
						<a href="{{ url('games/platforms/slug/'.$platform->slug) }}" title="Ver jogos de {{ $platform->name }}">
							{{ $platform->games->count() }}
						</a>
					</td>
					<td class="text-center">
						<a href="{{ url('ratings/platform/slug/'.$platform->slug) }}" title="Ver avaliações de {{ $platform->name }}">
							{{ $platform->ratings->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($platform->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'platforms.edit', $platform->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'platforms.destroy', $platform->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $platforms->links() }}
			</div>
		@endif
	</div>

@endsection

{{-- Admin::info('plataformas', 'Procurar plataforma', 'Criar Plataforma', 'plataformas/criacao') --}}
