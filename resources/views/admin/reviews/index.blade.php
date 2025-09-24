@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$reviews->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="23%">Jogo</th>
						<th width="23%">Plataforma</th>
						<th width="22%">Usuário</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($reviews as $review)
				<tr>
					<td>{!! Admin::date($review->extensive_updated_at) !!}</td>
					<td>
						@isset($review->rating->game)
							<a href="{{ url('reviews/game/id/'.$review->rating->game->id) }}" title="Ver análises de {{ $review->rating->game->name }}">
								{{ $review->rating->game->name }}
							</a>
						@endisset
					</td>
					<td>
						@isset($review->rating->platform)
							<a href="{{ url('reviews/platform/id/'.$review->rating->platform->id) }}" title="Ver análises de {{ $review->rating->platform->name }}">
								{{ $review->rating->platform->name }}
							</a>
						@endisset
					</td>
					<td>
						@isset($review->rating->user)
							<a href="{{ url('reviews/user/id/'.$review->rating->user->id) }}" title="Ver análises de {{ $review->rating->user->name }}">
								{{ $review->rating->user->name }}
							</a>
						@endisset
					</td>
					<td class="text-center">{!! Admin::action('edit', 'reviews.edit', $review->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'reviews.destroy', $review->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $reviews->links() }}
			</div>
		@endif
	</div>

@endsection
