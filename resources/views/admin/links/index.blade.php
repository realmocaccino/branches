@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Link') !!}</div>
			<div class="pull-right">{!! Admin::button('links.create', 'Criar Link') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$links->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="24%">{!! Admin::sort('name_pt', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="16%">{!! Admin::sort('route', 'Rota', 'Ordenar por rota') !!}</th>
						<th width="16%">Menu</th>
						<th width="10%" class="text-center">{!! Admin::sort('order', 'Ordem', 'Ordenar por ordem') !!}</th>
						<th width="8%" class="text-center">Status</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($links as $link)
				<tr>
					<td>{!! Admin::date($link->extensive_updated_at) !!}</td>
					<td>{{ $link->name_pt }}</td>
					<td>{{ $link->route }}</td>
					<td>@isset($link->menu) {{ $link->menu->name }} @endisset</td>
					<td class="text-center">{{ $link->order }}</td>
					<td class="text-center">{!! Admin::status($link->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'links.edit', $link->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'links.destroy', $link->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $links->links() }}
			</div>
		@endif
	</div>

@endsection
