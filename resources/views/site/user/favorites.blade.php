@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-favorites">{{ $total }}</span></strong> @lang('user/favorites.games')
	@elseif($total == 1)
		<strong><span class="total-user-favorites">1</span></strong> @lang('user/favorites.game')
	@else
		@lang('user/favorites.no_games')
	@endif
	
@endsection

@section('user_content')

	<div id="user-favorites">
		@if($games->count())
			<div class="row listing listing-nineColumns listing-games">
				<div class="col-12">
					<ul class="listing-items">
						@foreach($games as $game)
							<li>
								@component('site.components.item.game_raw', [
									'game' => $game
								])
								@endcomponent
							</li>
						@endforeach
					</ul>
					<div class="listing-pagination">
						{{ $games->links() }}
					</div>
				</div>
			</div>
		@endif
	</div>

@endsection