@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Tema') !!}</div>
			<div class="pull-right">{!! Admin::button('themes.create', 'Criar Tema') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$themes->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="50%">{!! Admin::sort('name_pt', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%" class="text-center">Jogos</th>
						<th width="10%" class="text-center">Status</th>
						<th width="10%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($themes as $theme)
				<tr>
					<td>{!! Admin::date($theme->extensive_updated_at) !!}</td>
					<td>{{ $theme->name_pt }}</td>
					<td class="text-center">
						<a href="{{ url('games/themes/slug/'.$theme->slug) }}" title="Ver jogos de {{ $theme->name }}">
							{{ $theme->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($theme->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'themes.edit', $theme->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'themes.destroy', $theme->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $themes->links() }}
			</div>
		@endif
	</div>

@endsection
