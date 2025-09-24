@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Característica') !!}</div>
			<div class="pull-right">{!! Admin::button('characteristics.create', 'Criar Característica') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$characteristics->count())
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
				@foreach($characteristics as $characteristic)
				<tr>
					<td>{!! Admin::date($characteristic->extensive_updated_at) !!}</td>
					<td>{{ $characteristic->name_pt }}</td>
					<td class="text-center">
						<a href="{{ url('games/characteristics/slug/'.$characteristic->slug) }}" title="Ver jogos de {{ $characteristic->name }}">
							{{ $characteristic->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($characteristic->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'characteristics.edit', $characteristic->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'characteristics.destroy', $characteristic->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $characteristics->links() }}
			</div>
		@endif
	</div>

@endsection
