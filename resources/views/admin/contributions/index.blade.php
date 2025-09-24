@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$contributions->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="25%">{!! Admin::sort('type', 'Tipo', 'Ordenar por tipo') !!}</th>
						<th width="25%">Jogo</th>
						<th width="25%">Usuário</th>
						<th width="7%" class="text-center">Ações</th>
					</tr>
				</thead>
				@foreach($contributions as $contribution)
				<tr>
					<td>{!! Admin::date($contribution->extensive_updated_at) !!}</td>
					<td>{{ $contribution->type }}</td>
					<td>
					@if($contribution->game)
						{{ $contribution->game->name }}
					@endif
					</td>
					<td>
					@if($contribution->user)
						{{ Str::words($contribution->user->name, 2) }} <em class="small">{{ $contribution->user->email }}</em>
					@endif
					</td>
					<td class="text-center">{!! Admin::action('delete', 'contributions.destroy', $contribution->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $contributions->links() }}
			</div>
		@endif
	</div>

@endsection
