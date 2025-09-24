@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Fabricante') !!}</div>
			<div class="pull-right">{!! Admin::button('manufacturers.create', 'Criar Fabricante') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$manufacturers->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="25%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%">{!! Admin::sort('foundation', 'Fundação', 'Ordenar por ano de fundação') !!}</th>
						<th width="25%">{!! Admin::sort('headquarters', 'Sede', 'Ordenar por sede') !!}</th>
						<th width="8%" class="text-center">Plataformas</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($manufacturers as $manufacturer)
				<tr>
					<td>{!! Admin::date($manufacturer->extensive_updated_at) !!}</td>
					<td>{{ $manufacturer->name }}</td>
					<td>{{ $manufacturer->foundation }}</td>
					<td>{{ $manufacturer->headquarters }}</td>
					<td class="text-center">
						<a href="{{ url('platforms/manufacturer/slug/'.$manufacturer->slug) }}" title="Ver jogos de {{ $manufacturer->name }}">
							{{ $manufacturer->platforms->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($manufacturer->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'manufacturers.edit', $manufacturer->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'manufacturers.destroy', $manufacturer->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $manufacturers->links() }}
			</div>
		@endif
	</div>

@endsection
