@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Planos') !!}</div>
			<div class="pull-right">{!! Admin::button('plans.create', 'Criar Plano') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$plans->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="36%">Nome</th>
						<th width="18%" class="text-center">{!! Admin::sort('price', 'Preço', 'Ordenar por preço') !!}</th>
						<th width="20%">{!! Admin::sort('days', 'Dias', 'Ordenar por dias') !!}</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($plans as $plan)
				<tr>
					<td>{!! Admin::date($plan->extensive_updated_at) !!}</td>
					<td>{{ $plan->name }}</td>
					<td class="text-center">{{ $plan->price }}</td>
					<td>{{ $plan->days }}</td>
					<td class="text-center">{!! Admin::action('edit', 'plans.edit', $plan->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'plans.destroy', $plan->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $plans->links() }}
			</div>
		@endif
	</div>

@endsection