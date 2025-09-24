@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Menu') !!}</div>
			<div class="pull-right">{!! Admin::button('menus.create', 'Criar Menu') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$menus->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="30%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="24%">{!! Admin::sort('slug', 'Slug', 'Ordenar por slug') !!}</th>
						<th width="12%" class="text-center">Links</th>
						<th width="8%" class="text-center">Status</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($menus as $menu)
				<tr>
					<td>{!! Admin::date($menu->extensive_updated_at) !!}</td>
					<td>{{ $menu->name }}</td>
					<td>{{ $menu->slug }}</td>
					<td class="text-center">
						<a href="{{ url('links/menu/slug/'.$menu->slug) }}" title="Ver links de {{ $menu->name }}">
							{{ $menu->links->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($menu->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'menus.edit', $menu->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'menus.destroy', $menu->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $menus->links() }}
			</div>
		@endif
	</div>

@endsection

{{-- Admin::info('menus', 'Procurar menu', 'Criar Menu', 'menus/criacao') --}}
