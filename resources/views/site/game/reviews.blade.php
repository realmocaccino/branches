@extends('site.layouts.game.index')

@section('internal_content')

	<div class="row" id="game-reviews-page">
		<div class="col-12">
			@component('site.components.title', [
				'title' => trans('game/reviews.reviews') . ($currentPlatform ? trans('game/reviews.reviews_on') . $currentPlatform->name : null)
			])
			@endcomponent
			<div class="row">
		        <div class="col-12">
			        <div id="reviews-header">
				        @isset($userRating)
					        @if(!$userRating->review)
						        @component('site.components.review.write', [
							        'rating' => $userRating
						        ])
						        @endcomponent
					        @endif
				        @else
					        @component('site.components.review.disabled', [
						        'game' => $game,
						        'buttonClass' => 'info'
					        ])
					        @endcomponent
				        @endisset
				    </div>
				</div>
			</div>
			@if($platformsToFilter->count() > 1)
			    <div class="row">
		            <div class="col-12">
				        <div id="game-reviews-platforms">
					        @foreach($platformsToFilter as $platform)
						        @component('site.components.item.platform_btn', [
							        'platform' => $platform,
							        'url' => route('game.reviews', [$game->slug, ($currentPlatform != $platform ? $platform->slug : null)]),
							        'active' => ($platform == $currentPlatform)
						        ])
						        @endcomponent
					        @endforeach
				        </div>
				    </div>
				</div>
			@endif
			<div class="row listing listing-twoColumns listing-reviews">
		        <div class="col-12">
			        @if($reviews->count())
				        <div id="reviews-items">
				            <ul class="listing-items">
					            @foreach($reviews as $review)
					                <li>
						                @component('site.components.item.review', [
							                'review' => $review,
							                'slide' => true
						                ])
						                @endcomponent
						            </li>
					            @endforeach
					        </ul>
				        </div>
				        <div class="listing-pagination">
				            {{ $reviews->links() }}
				        </div>
			        @endif
			    </div>
			</div>
		</div>
	</div>

@endsection

@section('sidebar')

    <div class="row">
        <div class="col-12">
            @component('site.game.components.relateds', [
                'relateds' => $relatedGames
            ])
            @endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('site.game.components.details')
            @include('site.game.components.contributors')
        </div>
    </div>

@endsection