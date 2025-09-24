@isset($latestReviews)
    <section id="game-index-reviews" class="not-bordered">
        @component('site.components.title', [
			'title' => trans('game/components/index/reviews.title') . ' (<span class="total-game-reviews">' . $game->reviews->count() . '</span>)'
		])
		@endcomponent
        <div id="game-index-reviews-header">
            <div id="reviews-header">
		        @if(!isset($userRating))
			        @component('site.components.review.disabled', [
				        'game' => $game
			        ])
			        @endcomponent
		        @elseif(!$userRating->review)
		            @component('site.components.review.write', [
                        'rating' => $userRating
                    ])
                    @endcomponent
		        @endif
		    </div>
	    </div>
	    <div id="game-index-reviews-items">
		    @if($latestReviews->count())
		        <div class="listing listing-oneColumn listing-reviews">
		            <ul class="listing-items">
			            @foreach($latestReviews as $review)
			                <li>
				                @component('site.components.item.review', [
					                'review' => $review
				                ])
				                @endcomponent
				            </li>
			            @endforeach
			        </ul>
			    </div>
		    @else
		       <div id="game-index-reviews-noReviews">
		           @include('site.components.neutral_face')
			       <p>@lang('game/components/index/reviews.no_reviews')</p>
			   </div>
		    @endif
	    </div>
	    @if($game->reviews->count() > $latestReviewsLimit)
		    <a id="game-index-reviews-more" class="btn btn-block btn-primary" href="{{ route('game.reviews', $game->slug) }}@if($agent->isMobile())#game-info-name @endif">@lang('game/components/index/reviews.read_all_reviews')</a>
	    @endif
    </section>
@endisset