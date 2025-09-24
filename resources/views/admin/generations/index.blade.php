@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Geração') !!}</div>
			<div class="pull-right">{!! Admin::button('generations.create', 'Criar Geração') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$generations->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="50%">{!! Admin::sort('name_pt', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%" class="text-center">Plataformas</th>
						<th width="10%" class="text-center">Status</th>
						<th width="10%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($generations as $generation)
				<tr>
					<td>{!! Admin::date($generation->extensive_updated_at) !!}</td>
					<td>{{ $generation->name }}</td>
					<td class="text-center">
						<a href="{{ url('platforms/generation/slug/'.$generation->slug) }}" title="Ver jogos de {{ $generation->name }}">
							{{ $generation->platforms->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($generation->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'generations.edit', $generation->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'generations.destroy', $generation->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $generations->links() }}
			</div>
		@endif
	</div>

@endsection
