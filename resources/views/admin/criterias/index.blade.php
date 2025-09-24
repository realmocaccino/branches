@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Critério de Avaliação') !!}</div>
			<div class="pull-right">{!! Admin::button('criterias.create', 'Criar Critério de Avaliação') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$criterias->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="50%">{!! Admin::sort('name_pt', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="10%" class="text-center">{!! Admin::sort('weight', 'Peso', 'Ordenar por peso') !!}</th>
						<th width="10%" class="text-center">{!! Admin::sort('order', 'Ordem', 'Ordenar por ordem') !!}</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($criterias as $criteria)
				<tr>
					<td>{!! Admin::date($criteria->extensive_updated_at) !!}</td>
					<td>{{ $criteria->name_pt }}</td>
					<td class="text-center">{{ $criteria->weight }}</td>
					<td class="text-center">{{ $criteria->order }}</td>
					<td class="text-center">{!! Admin::status($criteria->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'criterias.edit', $criteria->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'criterias.destroy', $criteria->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $criterias->links() }}
			</div>
		@endif
	</div>

@endsection
