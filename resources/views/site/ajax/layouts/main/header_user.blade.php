@guest('site')
	<a id="header-user-button" href="{{ route('login.index') }}" data-ajax-url="{{ route('login.ajax.index') }}" class="dialog btn btn-site">
		@lang('ajax/layouts/main/header_user.login')
	</a>
	<div id="header-user-icon">
		<a href="{{ route('login.index') }}" data-ajax-url="{{ route('login.ajax.index') }}" class="dialog">
		    <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" class="ff-ml-8 undefined"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 3a3 3 0 100 6 3 3 0 000-6zM7 6a5 5 0 1110 0A5 5 0 017 6zM2 22c0-5.523 4.477-10 10-10s10 4.477 10 10a1 1 0 11-2 0 8 8 0 10-16 0 1 1 0 11-2 0z"></path></svg>
		</a>
	</div>
@else
	<div id="header-user-feed">
		<a href="{{ route('feed.following') }}" title="@lang('ajax/layouts/main/header_user.feed')"></a>
	</div>
	<div id="header-user-picture">
		@component('site.components.item.user_picture', [
			'user' => $user,
			'size' => '180x',
			'noTitle' => true
		])
		@endcomponent
	</div>
	@if($user->unreadNotifications()->count())
		<a href="{{ route('notifications') }}">
			<span id="header-user-notifications" class="badge badge-pill badge-site">{{ $user->unreadNotifications()->count() }}</span>
		</a>
	@endif
@endif
<div id="header-user-tooltip" @guest('site') class="notLoggedIn" @endif>
	@guest('site')
		<ul id="header-user-tooltip-menu">
			<li><a href="{{ route('login.index') }}" data-ajax-url="{{ route('login.ajax.index') }}" class="dialog">@lang('ajax/layouts/main/header_user.login')</a></li>
			<li class="header-user-tooltip-menu-separator"></li>
			<li><a href="{{ route('register.index') }}" data-ajax-url="{{ route('register.ajax.index') }}" class="dialog">@lang('ajax/layouts/main/header_user.register')</a></li>
		</ul>
	@else
		<p id="header-user-tooltip-userData">
			<a href="{{ route('account.index') }}"><strong>{!! $user->name !!}</strong></a>
			<br>
			<a href="{{ route('account.index') }}" class="descriptive">{{ '@' . $user->slug }}</a>
		</p>
		<div id="header-user-tooltip-userLevel">
			@component('site.components.item.level', [
				'level' => $user->level
			])
			@endcomponent
		</div>
		<div class="clearfix"></div>
		@if(!$user->isPremium())
		    <hr>
		    <p>
		        @component('site.components.premium_icon')
	            @endcomponent
	            <a href="{{ route('premium.index') }}">
		            @lang('ajax/layouts/main/header_user.be_premium')
		        </a>
		    </p>
		@endif
		<hr>
		<p>
			<a href="{{ route('notifications') }}"><span class="badge badge-pill @if($user->unreadNotifications()->count()) badge-site @else badge-primary @endif">{{ $user->unreadNotifications()->count() }}</span> @lang('ajax/layouts/main/header_user.notifications_text')</a>
		</p>
		<hr>
		<p>
			<a href="{{ route('account.ratings') }}"><span class="total-user-ratings badge badge-pill badge-primary">{{ $user->ratings->count() }}</span> @lang('ajax/layouts/main/header_user.ratings_text')</a>
			<br>
			<a href="{{ route('account.reviews') }}"><span class="total-user-reviews badge badge-pill badge-primary">{{ $user->reviews->count() }}</span> @lang('ajax/layouts/main/header_user.reviews_text')</a>
		</p>
		@if($user->wishlistGames()->count())
		    <hr>
	        <p>
		        <a href="{{ route('collection.index', [$user->slug, 'wishlist']) }}"><span class="badge badge-pill badge-success">{{ $user->wishlistGames()->count() }}</span> @lang('ajax/layouts/main/header_user.wishlist_text')</a>
	        </p>
	    @endif
		<hr>
		<p>
			<a href="{{ route('account.edit.index') }}">@lang('ajax/layouts/main/header_user.edit_text')</a>
			<br>
			<a href="{{ route('logout') }}">@lang('ajax/layouts/main/header_user.logout_text')</a>
		</p>
	@endauth
</div>