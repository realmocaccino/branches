@extends('site.layouts.user.index')

@section('user_content')

	<div id="user-index">
        @if($followings->count() or $followers->count())
            <div class="row user-index-section">
                @if($followings->count())
                    <div class="col-12 col-xl-6 d-lg-none d-xl-block" id="user-index-following">
                        @component('site.components.preview', [
                            'title' => trans('user/index.following'),
                            'link' => route('user.following', $user->slug),
                            'items' => $followings,
                            'thumbnail_view' => 'site.components.item.user_picture',
                            'total' => $followings->total()
                        ])
                        @endcomponent
                    </div>
                @endif
                @if($followers->count())
                    <div class="col-12 col-xl-6 d-lg-none d-xl-block" id="user-index-followers">
                        @component('site.components.preview', [
                            'title' => trans('user/index.followers'),
                            'link' => route('user.followers', $user->slug),
                            'items' => $followers,
                            'thumbnail_view' => 'site.components.item.user_picture',
                            'total' => $followers->total()
                        ])
                        @endcomponent
                    </div>
                @endif
            </div>
        @endif
        @if($favoriteGames->count())
            <div class="row user-index-section">
                <div class="col-12 listing listing-games listing-tenColumns" id="user-index-favorites">
                	@component('site.components.title', [
                        'title' => trans('user/index.favorite_games'),
                        'link' => route('collection.index', [$user->slug, 'favorites']),
                        'arrow' => true
                    ])
                    @endcomponent
                    <ul class="listing-items">
                        @foreach($favoriteGames as $game)
                            <li>
                                @component('site.components.item.game', [
                                    'game' => $game
                                ])
                                @endcomponent
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($playingGames->count() or $collections->count())
            <div class="row user-index-section">
                @if($playingGames->count())
                    <div class="col-12 col-lg-6 col-xl-6 listing listing-games listing-fourColumns" id="user-index-playingGames">
                        <div class="user-index-section-contrast">
                            @component('site.components.title', [
                                'title' => trans('user/index.playing_now')
                            ])
                            @endcomponent
                            <ul class="listing-items">
                                @foreach($playingGames as $game)
                                    <li>
                                        @component('site.components.item.game', [
                                            'game' => $game,
                                            'withoutScore' => true
                                        ])
                                        @endcomponent
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                @if($collections->count())
                    <div class="col-12 col-lg-6 col-xl-6 listing listing-twoColumns" id="user-index-collections">
                        @component('site.components.title', [
                            'title' => trans('user/index.latest_collections'),
                            'link' => route('user.collections', $user->slug),
                            'arrow' => true
                        ])
                        @endcomponent
                        <ul class="listing-items">
                            @foreach($collections as $collection)
                                <li>
                                    @component('site.components.item.collection', [
                                        'collection' => $collection
                                    ])
                                    @endcomponent
                                </li>
                            @endforeach
                        </ul>
                        @if($totalCollections > $collectionsLimit)
                            <a id="user-index-collections-more" class="user-index-moreBtn btn btn-site btn-block" href="{{ route('user.collections', $user->slug) }}">@lang('user/index.see_all_collections') ({{ $totalCollections }})</a>
                        @endif
                    </div>
                @endif
            </div>
        @endif
        @if($contributions->count())
            <div class="row user-index-section">
                <div class="col-12 listing listing-games listing-tenColumns" id="user-index-contributions">
                	@component('site.components.title', [
                        'title' => trans('user/index.latest_contributions'),
                        'link' => route('user.contributions', $user->slug),
                        'arrow' => true
                    ])
                    @endcomponent
                    <ul class="listing-items">
                        @foreach($contributions as $contribution)
                            <li>
                                @component('site.components.item.game', [
                                    'game' => $contribution->game
                                ])
                                @endcomponent
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($mostLikedReviews->count())
            <div class="row user-index-section">
                <div class="col-12 listing listing-reviews listing-twoColumns" id="user-index-mostLikedReviews">
                	@component('site.components.title', [
                        'title' => trans('user/index.most_liked_reviews')
                    ])
                    @endcomponent
                    <ul class="listing-items">
                        @foreach($mostLikedReviews as $review)
                            <li>
                                @component('site.components.item.review', [
                                    'review' => $review,
                                    'cover' => 'game'
                                ])
                                @endcomponent
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($ratings->count())
            <div class="row user-index-section">
                <div class="col-12 listing listing-fiveColumns listing-ratings" id="user-index-ratings">
                    @component('site.components.title', [
                        'title' => trans('user/index.latest_ratings'),
                        'link' => route('user.ratings', $user->slug),
                        'arrow' => true
                    ])
                    @endcomponent
                    <ul class="listing-items">
                        @foreach($ratings as $rating)
                            <li>
	                            @component('site.components.item.rating', [
		                            'rating' => $rating
	                            ])
	                            @endcomponent
                            </li>
                        @endforeach
                    </ul>
                    @if($user->ratings->count() > $ratingsLimit)
                        <a id="user-index-ratings-more" class="user-index-moreBtn btn btn-site btn-block" href="{{ route('user.ratings', $user->slug) }}">@lang('user/index.see_all_ratings') ({{ $user->ratings->count() }})</a>
                    @endif
                </div>
            </div>
        @endif
        @if($bestRecentRatings->count())
            <div class="row user-index-section">
                <div class="col-12 listing listing-ratings listing-fiveColumns" id="user-index-bestRecentRatings">
                	@component('site.components.title', [
                        'title' => trans('user/index.best_recent_ratings')
                    ])
                    @endcomponent
                    <ul class="listing-items">
                        @foreach($bestRecentRatings as $rating)
                            <li>
                                @component('site.components.item.rating', [
                                    'rating' => $rating
                                ])
                                @endcomponent
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($wishlistGames->count())
            <div class="row user-index-section">
                <div class="col-12 listing listing-games listing-tenColumns" id="user-index-favorites">
                	@component('site.components.title', [
                        'title' => trans('user/index.wishlist_games'),
                        'link' => route('collection.index', [$user->slug, 'wishlist']),
                        'arrow' => true
                    ])
                    @endcomponent
                    <ul class="listing-items">
                        @foreach($wishlistGames as $game)
                            <li>
                                @component('site.components.item.game', [
                                    'game' => $game
                                ])
                                @endcomponent
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($reviews->count())
        	<div class="row user-index-section">
		        <div class="col-12 listing listing-twoColumns listing-reviews" id="user-index-reviews">
			        @component('site.components.title', [
				        'title' => trans('user/index.latest_reviews'),
				        'link' => route('user.reviews', $user->slug),
				        'arrow' => true
			        ])
			        @endcomponent
		            <ul class="listing-items">
			            @foreach($reviews as $review)
				            <li>
					            @component('site.components.item.review', [
						            'review' => $review,
						            'cover' => 'game'
					            ])
					            @endcomponent
				            </li>
			            @endforeach
		            </ul>
		            @if($user->reviews->count() > $reviewsLimit)
			            <a id="user-index-reviews-more" class="user-index-moreBtn btn btn-site btn-block" href="{{ route('user.reviews', $user->slug) }}">@lang('user/index.see_all_reviews') ({{ $user->reviews->count() }})</a>
		            @endif
		        </div>
		    </div>
		@endif
	</div>
	
@endsection