@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Franquia') !!}</div>
			<div class="pull-right">{!! Admin::button('franchises.create', 'Criar Franquia') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$franchises->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="30%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="28%">{!! Admin::sort('slug', 'Slug', 'Ordenar por slug') !!}</th>
						<th width="10%" class="text-center">Jogos</th>
						<th width="8%" class="text-center">Status</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($franchises as $franchise)
				<tr>
					<td>{!! Admin::date($franchise->extensive_updated_at) !!}</td>
					<td>{{ $franchise->name }}</td>
					<td>{{ $franchise->slug }}</td>
					<td class="text-center">
						<a href="{{ url('games/franchises/slug/'.$franchise->slug) }}" title="Ver jogos de {{ $franchise->name }}">
							{{ $franchise->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($franchise->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'franchises.edit', $franchise->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'franchises.destroy', $franchise->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $franchises->links() }}
			</div>
		@endif
	</div>

@endsection
