@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Usuário') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$users->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="32%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="30%">{!! Admin::sort('email', 'Email', 'Ordenar por email') !!}</th>
						<th width="6%" class="text-center">Avaliações</th>
						<th width="6%" class="text-center">Análises</th>
						<th width="4%" class="text-center">Status</th>
						<th width="4%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($users as $user)
				<tr>
					<td>{!! Admin::date($user->extensive_updated_at) !!}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td class="text-center">
						<a href="{{ url('ratings/user/id/'.$user->id) }}" title="Ver avaliações de {{ $user->name }}">
							{{ $user->ratings->count() }}
						</a>
					</td>
					<td class="text-center">
						<a href="{{ url('reviews/user/id/'.$user->id) }}" title="Ver análises de {{ $user->name }}">
							{{ $user->reviews->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($user->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'users.edit', $user->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'users.destroy', $user->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $users->links() }}
			</div>
		@endif
	</div>

@endsection
