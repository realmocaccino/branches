<div class="row" id="user-layout-header-menu">
	<div class="col-12">
		<ul>
			<li id="user-layout-header-menu-overview" @if(in_array($currentRouteName, ['user.index', 'account.index'])) class="active" @endif>
				<a href="{{ route('user.index', $user->slug) }}">@lang('layouts/user/menu.overview')</a>
			</li>
			<li id="user-layout-header-menu-ratings" class="@if(in_array($currentRouteName, ['user.ratings', 'account.ratings'])) active @endif @if(!$user->total_ratings) disabled @endif">
				<a href="{{ route('user.ratings', $user->slug) }}">@lang('layouts/user/menu.ratings') <span class="user-layout-header-menu-counter badge badge-pill @if($user->total_ratings) badge-primary @else badge-secondary @endif total-user-ratings">{{ $user->ratings()->count() }}</span></a>
			</li>
			@isset($totalCommonRatings)
				<li id="user-layout-header-menu-commonRatings" class="@if(in_array($currentRouteName, ['user.commonRatings'])) active @endif">
					<a href="{{ route('user.commonRatings', $user->slug) }}">@lang('layouts/user/menu.commonRatings') <span class="user-layout-header-menu-counter badge badge-pill @if($totalCommonRatings) badge-primary @else badge-secondary @endif">{{ $totalCommonRatings }}</span></a>
				</li>
			@endif
			<li id="user-layout-header-menu-reviews" class="@if(in_array($currentRouteName, ['user.reviews', 'account.reviews'])) active @endif @if(!$user->total_reviews) disabled @endif">
				<a href="{{ route('user.reviews', $user->slug) }}">@lang('layouts/user/menu.reviews') <span class="user-layout-header-menu-counter badge badge-pill @if($user->total_reviews) badge-primary @else badge-secondary @endif total-user-reviews">{{ $user->reviews()->count() }}</span></a>
			</li>
			<li id="user-layout-header-menu-collections" class="@if(in_array($currentRouteName, ['user.collections', 'account.collections'])) active @endif @if(!$totalCollections) disabled @endif">
				<a href="{{ route('user.collections', $user->slug) }}">@lang('layouts/user/menu.collections') <span class="user-layout-header-menu-counter badge badge-pill @if($totalCollections) badge-primary @else badge-secondary @endif">{{ $totalCollections }}</span></a>
			</li>
			<li id="user-layout-header-menu-favorites" class="@if(in_array($currentRouteName, ['user.favorites', 'account.favorites'])) active @endif @if(!$user->favoriteGames()->count()) disabled @endif">
				<a href="{{ route('user.favorites', $user->slug) }}">@lang('layouts/user/menu.favorites') <span class="user-layout-header-menu-counter badge badge-pill @if($user->favoriteGames()->count()) badge-primary @else badge-secondary @endif">{{ $user->favoriteGames()->count() }}</span></a>
			</li>
			<li id="user-layout-header-menu-wishlist" class="@if(in_array($currentRouteName, ['user.wishlist', 'account.wishlist'])) active @endif @if(!$user->wishlistGames()->count()) disabled @endif">
				<a href="{{ route('user.wishlist', $user->slug) }}">@lang('layouts/user/menu.wishlist') <span class="user-layout-header-menu-counter badge badge-pill @if($user->wishlistGames()->count()) badge-primary @else badge-secondary @endif">{{ $user->wishlistGames()->count() }}</span></a>
			</li>
			<li id="user-layout-header-menu-followings" class="@if(in_array($currentRouteName, ['user.following', 'account.following'])) active @endif @if(!$user->followings()->count()) disabled @endif">
				<a href="{{ route('user.following', $user->slug) }}">@lang('layouts/user/menu.followings') <span class="user-layout-header-menu-counter badge badge-pill @if($user->followings()->count()) badge-primary @else badge-secondary @endif">{{ $user->followings()->count() }}</span></a>
			</li>
			<li id="user-layout-header-menu-followers" class="@if(in_array($currentRouteName, ['user.followers', 'account.followers'])) active @endif @if(!$user->followers()->count()) disabled @endif">
				<a href="{{ route('user.followers', $user->slug) }}">@lang('layouts/user/menu.followers') <span class="user-layout-header-menu-counter badge badge-pill @if($user->followers()->count()) badge-primary @else badge-secondary @endif">{{ $user->followers()->count() }}</span></a>
			</li>
			<li id="user-layout-header-menu-contributions" class="@if(in_array($currentRouteName, ['user.contributions', 'account.contributions'])) active @endif @if(!$user->total_contributions) disabled @endif">
				<a href="{{ route('user.contributions', $user->slug) }}">@lang('layouts/user/menu.contributions') <span class="user-layout-header-menu-counter badge badge-pill @if($user->total_contributions) badge-primary @else badge-secondary @endif total-user-contributions">{{ $user->total_contributions }}</span></a>
			</li>
			<li id="user-layout-header-menu-likedReviews" class="@if(in_array($currentRouteName, ['user.likedReviews', 'account.likedReviews'])) active @endif @if(!$user->positiveReviewsFeedbacksGiven()->count()) disabled @endif">
				<a href="{{ route('user.likedReviews', $user->slug) }}">@lang('layouts/user/menu.likedReviews') <span class="user-layout-header-menu-counter badge badge-pill @if($user->positiveReviewsFeedbacksGiven()->count()) badge-primary @else badge-secondary @endif">{{ $user->positiveReviewsFeedbacksGiven()->count() }}</span></a>
			</li>
		</ul>
	</div>
</div>