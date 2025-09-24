@auth('site')
	<div id="mobile-side-user-header">
		@component('site.components.item.user_picture', [
			'user' => $user,
			'size' => '180x',
			'noTitle' => true
		])
		@endcomponent
		<div id="mobile-side-user-header-data">
			<p id="mobile-side-user-header-name">
				<a href="{{ route('account.index') }}"><strong>{!! $user->name !!}</strong></a>
			</p>
			<p id="mobile-side-user-header-username">
				<a href="{{ route('account.index') }}" class="descriptive">{{ '@' . $user->slug }}</a>
			</p>
		</div>
		<div id="mobile-side-user-level">
			@component('site.components.item.level', [
				'level' => $user->level
			])
			@endcomponent
		</div>
		<p id="mobile-side-user-header-actions">
			<a href="{{ route('account.edit.index') }}" class="badge badge-primary">@lang('ajax/layouts/main/side_user.edit')</a> <a href="{{ route('logout') }}" class="badge badge-secondary">@lang('ajax/layouts/main/side_user.logout')</a>
		</p>
		<div class="clearfix"></div>
	</div>
	<div id="mobile-side-user-body">
	    @if(!$user->isPremium())
		    <p>
		        @component('site.components.premium_icon')
	            @endcomponent
	            <a href="{{ route('premium.index') }}">
		            <span class="ordinary-text">@lang('ajax/layouts/main/side_user.be_premium')</span>
		        </a>
		    </p>
		    <hr>
		@endif
	    <p id="mobile-side-user-body-notifications">
			<a href="{{ route('notifications') }}"><span class="badge badge-pill @if($user->unreadNotifications()->count()) badge-site @else badge-primary @endif">{{ $user->unreadNotifications()->count() }}</span> <span class="ordinary-text">@lang('ajax/layouts/main/side_user.notifications')</span></a>
		</p>
		<hr>
		<p>
			<a href="{{ route('account.ratings') }}"><span class="total-user-ratings badge badge-pill badge-primary">{{ $user->ratings->count() }}</span> <span class="ordinary-text">@lang('ajax/layouts/main/side_user.ratings')</span></a>
			&bull;
			<a href="{{ route('account.reviews') }}"><span class="total-user-reviews badge badge-pill badge-primary">{{ $user->reviews->count() }}</span> <span class="ordinary-text">@lang('ajax/layouts/main/side_user.reviews')</span></a>
		</p>
		<hr>
		<p>
			<a href="{{ route('account.following') }}"><span class="total-user-followings badge badge-pill badge-primary">{{ $user->followings->count() }}</span> <span class="ordinary-text">@lang('ajax/layouts/main/side_user.following')</span></a>
			&bull;
			<a href="{{ route('account.followers') }}"><span class="total-user-followers badge badge-pill badge-primary">{{ $user->followers->count() }}</span> <span class="ordinary-text">@lang('ajax/layouts/main/side_user.followers')</span></a>
		</p>
		<hr>
		@if($user->wishlistGames()->count())
		    <p>
			    <a href="{{ route('collection.index', [$user->slug, 'wishlist']) }}"><span class="badge badge-pill badge-success">{{ $user->wishlistGames()->count() }}</span> <span class="ordinary-text">@lang('ajax/layouts/main/side_user.wishlist')</span></a>
		    </p>
		    <hr>
		@endif
		@if($user->ratings->count())
			@component('site.components.title', [
				'title' => trans('ajax/layouts/main/side_user.last_ratings')
			])
			@endcomponent
			<ul class="listing-items">
				@foreach($user->ratings()->take(8)->get() as $rating)
					<li>
						<?php echo str_replace('Escrever análise', 'Analisar', view('site.components.item.rating', [
							'rating' => $rating,
							'nameLimit' => 14,
							'noChart' => true
						])->render()); ?>
					</li>
				@endforeach
			</ul>
			@if($user->ratings->count() > 8)
				<a id="mobile-side-user-header-seeAllRatings-btn" class="btn btn-small btn-primary" href="{{ route('user.ratings', $user->slug) }}">@lang('ajax/layouts/main/side_user.see_all')</a>
			@endif
		@endif
	</div>
@endauth