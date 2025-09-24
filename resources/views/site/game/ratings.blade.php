@extends('site.layouts.game.open')

@section('internal_content')

	<div class="row" id="game-ratings-page">
		<div class="col-12">
		    <div class="row">
		        <div class="col-12">
                    @component('site.components.title', [
				        'title' => trans('game/ratings.ratings') . ($currentPlatform ? trans('game/ratings.ratings_on') . $currentPlatform->name : null)
			        ])
			        @endcomponent
			    </div>
			</div>
			<div class="row">
		        <div class="col-12">
			        @if(!$game->ratings->count())
			            <div id="game-ratings-noRatings">
			                @include('site.components.neutral_face', [
                                'size' => 'big'
                            ])
				            <p id="game-ratings-page-firstToRate">@lang('game/ratings.be_the_first') <a class="dialog underscore" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}">@lang('game/ratings.rate_the_game')</a></p>
				        </div>
			        @endif
			        @if($platformsToFilter->count() > 1)
				        <div id="game-ratings-platforms">
					        @foreach($platformsToFilter as $platform)
						        @component('site.components.item.platform_btn', [
							        'platform' => $platform,
							        'url' => route('game.ratings', [$game->slug, ($currentPlatform != $platform ? $platform->slug : null)]),
							        'active' => ($platform == $currentPlatform)
						        ])
						        @endcomponent
					        @endforeach
				        </div>
			        @endif
			    </div>
			</div>
			<div class="row listing listing-fourColumns listing-ratings">
		        <div class="col-12">
			        @if($ratings->count())
				        <ul class="listing-items">
					        @foreach($ratings as $rating)
						        <li>
							        @component('site.components.item.rating', [
								        'rating' => $rating,
								        'cover' => 'user'
							        ])
							        @endcomponent
						        </li>
					        @endforeach
				        </ul>
				        <div class="listing-pagination">
				            {{ $ratings->links() }}
				        </div>
			        @endif
			    </div>
			</div>
		</div>
	</div>

@endsection