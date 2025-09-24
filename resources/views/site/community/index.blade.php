@extends('site.layouts.internal.index')

@section('internal_content')

	<div id="community">
		<div class="row">
		    <div class="col-xl-9 col-lg-8 col-12">
				@if($playingNowGames->count())
					<div class="row">
						<div class="col-12 community-section listing listing-games listing-sevenColumns" id="community-playingNowGames">
							<div class="community-section-contrast">
								@component('site.components.title', [
									'title' => trans('community/index.what_community_is_playing')
								])
								@endcomponent
								<ul class="listing-items">
									@foreach($playingNowGames as $game)
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
					</div>
				@endif
		        @if($spotlightUsers->count())
                    <div class="row">
	                    <div class="col-12 community-section" id="community-spotlight">
                            @component('site.components.title', [
                                'title' => trans('community/index.users_on_spotlight'),
                                'link' => route('ranking.users', 7),
                                'arrow' => true
                            ])
                            @endcomponent
                            <ul>
		                        @foreach($spotlightUsers as $user)
			                        <li>
				                        <div class="community-spotlight-pos">
					                        <div class="rankingPosition">{{ ++$startingPosition . 'º' }}</div>
				                        </div>
				                        <div class="community-spotlight-item">
				                            @component('site.components.item.user', [
                                                'user' => $user
                                            ])
                                            @endcomponent
				                        </div>
			                        </li>
		                        @endforeach
	                        </ul>
                        </div>
                    </div>
                @endif
				<div class="row">
		        	@if($reviews->count())
			            <div class="col-xl-8 col-12 listing listing-oneColumn community-section" id="community-reviews">
		                    @component('site.components.title', [
                                'title' => trans('community/index.latest_reviews'),
                                'link' => route('reviews'),
                                'arrow' => true
                            ])
                            @endcomponent
		                    <ul class="listing-items">
		                        @foreach($reviews as $review)
		                            <li>
			                            @component('site.components.item.review', [
				                            'review' => $review,
				                            'cover' => 'game_user'
			                            ])
			                            @endcomponent
			                        </li>
		                        @endforeach
		                    </ul>
		                    <a class="community-moreBtn btn btn-outline-site" href="{{ route('reviews') }}">@lang('community/index.see_all_reviews')</a>
		                </div>
		        	@endif
		        	@if($ratings->count())
			            <div class="col-xl-4 col-12 listing listing-oneColumn community-section" id="community-ratings">
		                    @component('site.components.title', [
                                'title' => trans('community/index.latest_ratings'),
                                'link' => route('ratings'),
                                'arrow' => true
                            ])
                            @endcomponent
		                    <ul class="listing-items">
		                        @foreach($ratings as $rating)
		                            <li>
			                            @component('site.components.item.rating', [
				                            'rating' => $rating,
				                            'cover' => 'game_user'
			                            ])
			                            @endcomponent
			                        </li>
		                        @endforeach
		                    </ul>
		                    <a class="community-moreBtn btn btn-outline-site" href="{{ route('ratings') }}">@lang('community/index.see_all_ratings')</a>
		                </div>
		        	@endif
				</div>
				@if($anticipatedGames->count())
					<div class="row user-index-section">
						<div class="col-12 community-section listing listing-games listing-sevenColumns" id="user-index-favorites">
							<div class="community-section-contrast">
								@component('site.components.title', [
									'title' => trans('community/index.what_community_most_anticipate')
								])
								@endcomponent
								<ul class="listing-items">
									@foreach($anticipatedGames as $game)
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
					</div>
				@endif
		        @if($discussions->count())
	                <div class="row">
			            <div class="col-12 listing listing-oneColumn community-section" id="community-discussions">
	                        @component('site.components.title', [
		                        'title' => trans('community/index.latest_discussions'),
		                        'class' => 'float-left',
		                        'link' => route('forum.index'),
		                        'arrow' => true
	                        ])
	                        @endcomponent
	                        @component('site.forum.components.create_btn')
	                        @endcomponent
	                        @component('site.forum.components.discussions_list', [
		                        'discussions' => $discussions
	                        ])
	                        @endcomponent
		                    <a class="community-moreBtn btn btn-outline-site" href="{{ route('forum.index') }}">@lang('community/index.see_all_discussions')</a>
                        </div>
		            </div>
                @endif
	        </div>
			<div class="col-xl-3 col-lg-4 col-12">
				@if($contributions->count())
					<div class="row">
						<div class="col-12 listing listing-oneColumn community-section" id="community-contributions">
							<div class="community-section-contrast">
								@component('site.components.title', [
									'title' => trans('community/index.latest_contributions'),
									'link' => route('contributions'),
									'arrow' => true
								])
								@endcomponent
								<ul class="listing-items">
									@foreach($contributions as $contribution)
										<li>
											@component('site.components.item.contribution', [
												'contribution' => $contribution
											])
											@endcomponent
										</li>
									@endforeach
								</ul>
								<a class="community-moreBtn btn btn-outline-site" href="{{ route('contributions') }}">@lang('community/index.see_all_contributions')</a>
							</div>
						</div>
					</div>
				@endif
				<div class="row">
					<div class="col-12 community-section" id="community-search">
						@component('site.components.title', [
                            'title' => trans('community/index.search_users')
                        ])
						@endcomponent
						<form class="form-inline" method="get" action="{{ route('search.users') }}" id="community-search-form">
							<div class="form-group">
								<input id="community-search-form-input" class="form-control" type="text" name="term" placeholder="@username" pattern=".{3,}" required>
								<button id="community-search-form-button" class="btn btn-sm btn-site" type="submit">@lang('community/index.search')</button>
							</div>
						</form>
					</div>
				</div>
				@if($collections->count())
					<div class="row">
						<div class="col-12 listing listing-oneColumn community-section" id="community-collections">
							<div class="community-section-contrast">
								@component('site.components.title', [
									'title' => trans('community/index.latest_collections'),
									'link' => route('collections.index'),
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
								<a class="community-moreBtn btn btn-outline-site" href="{{ route('collections.index') }}">@lang('community/index.see_all_collections')</a>
							</div>
						</div>
					</div>
				@endif
			</div>
	    </div>
	</div>

@endsection