@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Papel') !!}</div>
			<div class="pull-right">{!! Admin::button('roles.create', 'Criar Papel') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$roles->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="76%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($roles as $role)
				<tr>
					<td>{!! Admin::date($role->extensive_updated_at) !!}</td>
					<td>{{ $role->name }}</td>
					<td class="text-center">{!! Admin::action('edit', 'roles.edit', $role->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'roles.destroy', $role->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $roles->links() }}
			</div>
		@endif
	</div>

@endsection

{{-- Admin::info('administratores', 'Procurar papel', 'Criar Papel', 'administratores/criacao') --}}
