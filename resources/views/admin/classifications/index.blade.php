@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Classificação Indicativa') !!}</div>
			<div class="pull-right">{!! Admin::button('classifications.create', 'Criar Classificação Indicativa') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$classifications->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="58%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="8%" class="text-center">Jogos</th>
						<th width="8%" class="text-center">Status</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($classifications as $classification)
				<tr>
					<td>{!! Admin::date($classification->extensive_updated_at) !!}</td>
					<td>{{ $classification->name }}</td>
					<td class="text-center">
						<a href="{{ url('games/classifications/slug/'.$classification->slug) }}" title="Ver jogos de {{ $classification->name }}">
							{{ $classification->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($classification->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'classifications.edit', $classification->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'classifications.destroy', $classification->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $classifications->links() }}
			</div>
		@endif
	</div>

@endsection
