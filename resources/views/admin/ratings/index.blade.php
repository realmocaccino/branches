@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$ratings->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="23%">Jogo</th>
						<th width="23%">Plataforma</th>
						<th width="22%">Usuário</th>
						<th width="8%" class="text-center">Nota</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($ratings as $rating)
				<tr>
					<td>{!! Admin::date($rating->extensive_updated_at) !!}</td>
					<td>
						@isset($rating->game)
							<a href="{{ url('ratings/game/id/'.$rating->game->id) }}" title="Ver avaliações de {{ $rating->game->name }}">
								{{ $rating->game->name }}
							</a>
						@endisset
					</td>
					<td>
						@isset($rating->platform)
							<a href="{{ url('ratings/platform/id/'.$rating->platform->id) }}" title="Ver avaliações de {{ $rating->platform->name }}">
								{{ $rating->platform->name }}
							</a>
						@endisset
					</td>
					<td>
						@isset($rating->user)
							<a href="{{ url('ratings/user/id/'.$rating->user->id) }}" title="Ver avaliações de {{ $rating->user->name }}">
								{{ $rating->user->name }}
							</a>
						@endisset
					</td>
					<td class="text-center">{!! str_replace('.', ',', $rating->score) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'ratings.edit', $rating->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'ratings.destroy', $rating->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $ratings->links() }}
			</div>
		@endif
	</div>

@endsection
