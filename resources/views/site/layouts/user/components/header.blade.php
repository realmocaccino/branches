@if($user->isPremium() and $user->background)

	<style>
		#user-layout-header {
			background: linear-gradient(transparent, var(--user-header-background-color) @if($agent->isMobile()) 245px @else 300px @endif), url('{{ $user->getBackground($agent->isMobile() ? '576x324' : '1920x1080') }}') fixed;
		}

		.dark #user-layout-header {
			background: linear-gradient(transparent, var(--dark-mode-user-header-background-color) @if($agent->isMobile()) 245px @else 300px @endif), url('{{ $user->getBackground($agent->isMobile() ? '576x324' : '1920x1080') }}') fixed;
		}
	</style>

@endif

<div id="user-layout-header" @if(!$user->isPremium() or !$user->background) class="noBackground" @endif>
	<div class="container">
	    <div class="row">
		    <div class="col-xl-2 col-lg-3 col-md-3 col-sm-4 col-12" id="user-layout-header-left">
		        <div id="user-layout-header-left-container">
	                @component('site.components.item.user_picture', [
		                'user' => $user,
		                'size' => '180x'
	                ])
	                @endcomponent
		        </div>
		    </div>
		    <div class="col-xl-10 col-lg-9 col-md-9 col-sm-8 col-12" id="user-layout-header-right">
		        <div id="user-layout-header-info">
			        <h3 id="user-layout-header-name">
				        <a href="{{ route('user.index', [$user->slug]) }}">
					        {{ $user->name }}
				        </a>
						@component('site.components.item.level', [
							'level' => $user->level
						])
						@endcomponent
				        @if($user->isPremium())
				            @component('site.components.premium_icon')
	                        @endcomponent
	                    @endif
			        </h3>
			        <p id="user-layout-header-username">
				        <a href="{{ route('user.index', [$user->slug]) }}">
					        {{ '@' . $user->slug }}
				        </a>
			        </p>
			        @if($followsYou)
			            <p>
							<span class="badge badge-primary">@lang('layouts/user/header.follows_you')</span>
						</p>
			        @endif
					@if($badges = $user->retrieveBadges())
						<ul id="user-layout-header-badges">
							@foreach($badges as $badge)
								<li>
									<img src="{{ asset($badge['asset']) }}" title="{{ $badge['description'] }}"></img>
								</li>
							@endforeach
						</ul>
					@endif
					@if($user->bio)
				        <p id="user-layout-header-bio">
					        <span class="fa fa-quote-left"></span> {{ $user->bio }} <span class="fa fa-quote-right"></span>
				        </p>
			        @endif
			        <div id="user-layout-header-actionButton">
		                @if($isLoggedInUser)
		                    <a id="user-layout-header-manageAccount" class="btn btn-outline-secondary" data-dropdown="user-layout-header-manageAccountTooltip" href="#">
                                @lang('layouts/user/header.manage_account')
                            </a>
                            @component('site.layouts.user.components.menu_account')@endcomponent
                        @else
                            @if(!$user->isFollowedBy($loggedInUser))
                                <a href="{{ route('user.follow', $user->slug) }}" class="btn btn-info">@lang('layouts/user/header.follow')</a>
                            @else
                                <a href="{{ route('user.unfollow', $user->slug) }}" class="btn btn-info"><em class="fa fa-check"></em> @lang('layouts/user/header.following')</a>
                            @endif
                        @endif
		            </div>
		            @if($isLoggedInUser)
	                    <a id="user-layout-header-premium" href="{{ route('premium.index') }}" class="btn btn-warning">
                            @if(!$user->isPremium())
                                @lang('layouts/user/header.be_premium')
                            @else
                                @lang('layouts/user/header.manage_subscription')
                            @endif
                        </a>
                    @endif
			    </div>
		    </div>
	    </div>
	    @include('site.layouts.user.components.menu')
    </div>
</div>