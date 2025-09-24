@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Jogo') !!}</div>
			<div class="pull-right">{!! Admin::button('games.create', 'Criar Jogo') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$games->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="25%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%">{!! Admin::sort('release', 'Lançamento', 'Ordenar por data de lançamento') !!}</th>
						<th width="25%">Plataforma(s)</th>
						<th width="6%" class="text-center">Avaliações</th>
						<th width="6%" class="text-center">Análises</th>
						<th width="4%" class="text-center">Status</th>
						<th width="4%" class="text-center" colspan="3">Ações</th>
					</tr>
				</thead>
				@foreach($games as $game)
				<tr>
					<td>{!! Admin::date($game->extensive_updated_at) !!}</td>
					<td>{{ $game->name }}</td>
					<td>@if(!$game->isUndated()) {{ $game->release->format('d/m/Y') }} @endif</td>
					<td>{{ implode(', ', $game->platforms()->orderBy('name')->pluck('initials')->all()) }}</td>
					<td class="text-center">
						<a href="{{ url('ratings/game/id/'.$game->id) }}" title="Ver avaliações de {{ $game->name }}">
							{{ $game->ratings->count() }}
						</a>
					</td>
					<td class="text-center">
						<a href="{{ url('reviews/game/id/'.$game->id) }}" title="Ver análises de {{ $game->name }}">
							{{ $game->reviews->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($game->status) !!}</td>
					<td class="text-center">
						@if($game->status)
							<a href="{{ config('app.url') }}/{{ $game->slug }}" title="Ver Jogo" target="_blank">
								<span class="glyphicon glyphicon-eye-open" alt="Ver"></span>
							</a>
						@endif
					</td>
					<td class="text-center">{!! Admin::action('edit', 'games.edit', $game->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'games.destroy', $game->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $games->links() }}
			</div>
		@endif
	</div>
	
@endsection
