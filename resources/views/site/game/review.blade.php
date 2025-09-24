@extends('site.layouts.game.index')

@section('internal_content')

	<div class="row" id="game-review-page">
		<div class="col-12">
			<div id="review-header">
				@isset($userRating)
					@if(!$userRating->review)
						@component('site.components.review.write', [
							'rating' => $userRating
						])
						@endcomponent
					@endif
				@else
					@component('site.components.review.disabled', [
						'game' => $game
					])
					@endcomponent
				@endisset
			</div>
			<div id="reviews-items">
				<div class="listing listing-oneColumn listing-reviews">
					<ul class="listing-items">
						<li>
							@component('site.components.item.review', [
								'review' => $review,
								'noSumUp' => true
							])
							@endcomponent
						</li>
					</ul>
				</div>
				@if($otherReviews->count())
				    @component('site.components.title', [
						'title' => trans('game/review.other_reviews')
					])
					@endcomponent
					<div class="listing listing-twoColumns listing-reviews">
					    <ul class="listing-items">
				            @foreach($otherReviews as $review)
				                <li>
				                    @component('site.components.item.review', [
					                    'review' => $review
				                    ])
				                    @endcomponent
				                </li>
				            @endforeach
				        </ul>
				    </div>
				@endif
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