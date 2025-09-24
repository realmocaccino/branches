@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Publicadora') !!}</div>
			<div class="pull-right">{!! Admin::button('publishers.create', 'Criar Publicadora') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$publishers->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="25%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%">{!! Admin::sort('foundation', 'Fundação', 'Ordenar por ano de fundação') !!}</th>
						<th width="25%">{!! Admin::sort('headquarters', 'Sede', 'Ordenar por sede') !!}</th>
						<th width="8%" class="text-center">Jogos</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($publishers as $publisher)
				<tr>
					<td>{!! Admin::date($publisher->extensive_updated_at) !!}</td>
					<td>{{ $publisher->name }}</td>
					<td>{{ $publisher->foundation }}</td>
					<td>{{ $publisher->headquarters }}</td>
					<td class="text-center">
						<a href="{{ url('games/publishers/slug/'.$publisher->slug) }}" title="Ver jogos de {{ $publisher->name }}">
							{{ $publisher->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($publisher->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'publishers.edit', $publisher->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'publishers.destroy', $publisher->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $publishers->links() }}
			</div>
		@endif
	</div>

@endsection
