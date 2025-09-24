<section id="game-index-ratings" class="listing listing-oneColumn">
	@if($game->ratings()->count())
		@component('site.components.title', [
			'title' => trans('game/components/index/ratings.title')
		])
		@endcomponent
		<ul class="listing-items">
			@foreach($game->ratings()->take($latestRatingsLimit)->get() as $rating)
				<li>
					@component('site.components.item.rating', [
						'rating' => $rating,
						'cover' => 'user'
					])
					@endcomponent
				</li>
			@endforeach
		</ul>
		@if($game->ratings->count() > $latestRatingsLimit)
		    <a id="game-ratings-more" class="btn btn-block btn-site" href="{{ route('game.ratings', $game->slug) }}@if($agent->isMobile())#game-info-name @endif">@lang('game/components/index/ratings.see_all_ratings')  (<span class="total-game-ratings">{{ $game->ratings->count() }}</span>)</a>
	    @endif
	@endif
</section>