@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Desenvolvedora') !!}</div>
			<div class="pull-right">{!! Admin::button('developers.create', 'Criar Desenvolvedora') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$developers->count())
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
				@foreach($developers as $developer)
				<tr>
					<td>{!! Admin::date($developer->extensive_updated_at) !!}</td>
					<td>{{ $developer->name }}</td>
					<td>{{ $developer->foundation }}</td>
					<td>{{ $developer->headquarters }}</td>
					<td class="text-center">
						<a href="{{ url('games/developers/slug/'.$developer->slug) }}" title="Ver jogos de {{ $developer->name }}">
							{{ $developer->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($developer->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'developers.edit', $developer->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'developers.destroy', $developer->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $developers->links() }}
			</div>
		@endif
	</div>

@endsection
