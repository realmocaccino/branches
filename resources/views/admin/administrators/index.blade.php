@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Administrator') !!}</div>
			<div class="pull-right">{!! Admin::button('administrators.create', 'Criar Administrator') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$administrators->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="25%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="25%">{!! Admin::sort('email', 'Email', 'Ordenar por email') !!}</th>
						<th width="20%">Papel</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($administrators as $administrator)
				<tr>
					<td>{!! Admin::date($administrator->extensive_updated_at) !!}</td>
					<td>{{ $administrator->name }}</td>
					<td>{{ $administrator->email }}</td>
					<td>{{ $administrator->role->name }}</td>
					<td class="text-center">{!! Admin::status($administrator->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'administrators.edit', $administrator->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'administrators.destroy', $administrator->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $administrators->links() }}
			</div>
		@endif
	</div>

@endsection

{{-- Admin::info('administratores', 'Procurar administrator', 'Criar Administrator', 'administratores/criacao') --}}
