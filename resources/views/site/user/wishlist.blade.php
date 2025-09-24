@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-wishlist">{{ $total }}</span></strong> @lang('user/wishlist.games')
	@elseif($total == 1)
		<strong><span class="total-user-wishlist">1</span></strong> @lang('user/wishlist.game')
	@else
		@lang('user/wishlist.no_games')
	@endif
	
@endsection

@section('user_content')

	<div id="user-wishlist">
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