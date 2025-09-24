@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Modo de Jogo') !!}</div>
			<div class="pull-right">{!! Admin::button('modes.create', 'Criar Modo de Jogo') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$modes->count())
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
				@foreach($modes as $mode)
				<tr>
					<td>{!! Admin::date($mode->extensive_updated_at) !!}</td>
					<td>{{ $mode->name_pt }}</td>
					<td class="text-center">
						<a href="{{ url('games/modes/slug/'.$mode->slug) }}" title="Ver jogos de {{ $mode->name }}">
							{{ $mode->games->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($mode->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'modes.edit', $mode->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'modes.destroy', $mode->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $modes->links() }}
			</div>
		@endif
	</div>

@endsection
