@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Gênero') !!}</div>
			<div class="pull-right">{!! Admin::button('genres.create', 'Criar Gênero') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$genres->count())
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
				@foreach($genres as $genre)
				<tr>
					<td>{!! Admin::date($genre->extensive_updated_at) !!}</td>
					<td>{{ $genre->name_pt }}</td>
					<td class="text-center">
						<a href="{{ url('games/genres/slug/'.$genre->slug) }}" title="Ver jogos de {{ $genre->name_pt }}">
							{{ $genre->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($genre->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'genres.edit', $genre->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'genres.destroy', $genre->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $genres->links() }}
			</div>
		@endif
	</div>

@endsection
