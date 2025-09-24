<section id="game-menu">
	<ul>
		<li id="game-menu-index" @if($currentRouteName == 'game.index') class="active" @endif>
			<a href="{{ route('game.index', $game->slug) }}">@lang('game/components/menu.overview')</a>
		</li>
	    @if($game->isAvailable() and $game->trailer)
	        <li id="game-menu-trailer" @if($currentRouteName == 'game.trailer') class="active" @endif>
		        <a href="{{ route('game.trailer', $game->slug) }}">@lang('game/components/menu.trailer')</a>
	        </li>
        @endif
        @if($game->screenshots->count())
		    <li id="game-menu-screenshots" @if($currentRouteName == 'game.screenshots') class="active" @endif>
                <a href="{{ route('game.screenshots', $game->slug) }}">@lang('game/components/menu.screenshots') <span class="badge badge-pill badge-primary">{{ $game->screenshots->count() }}</span></a>
            </li>
        @endif
		@if($game->isAvailable())
	        <li id="game-menu-ratings" @if($currentRouteName == 'game.ratings') class="active" @endif>
			    <a href="{{ route('game.ratings', $game->slug) }}">@lang('game/components/menu.ratings') <span class="badge badge-pill badge-primary total-game-ratings">{{ $game->total_ratings }}</span></a>
		    </li>
		    <li id="game-menu-reviews" @if(in_array($currentRouteName, ['game.reviews', 'game.review'])) class="active" @endif>
				<a href="{{ route('game.reviews', $game->slug) }}">@lang('game/components/menu.reviews') <span class="badge badge-pill badge-primary total-game-reviews">{{ $game->total_reviews }}</span></a>
			</li>
	    @endif
	    <li id="game-menu-forum" @if(strstr($currentRouteName, 'game.forum')) class="active" @endif>
			<a href="{{ route('game.forum.index', $game->slug) }}">@lang('game/components/menu.discussions') <span class="badge badge-pill badge-primary">{{ $game->discussions->count() }}</span></a>
		</li>
		@if($game->contributions->count())
		    <li id="game-menu-contributions" @if($currentRouteName == 'game.contributions') class="active" @endif>
			    <a href="{{ route('game.contributions', $game->slug) }}">@lang('game/components/menu.contributions') <span class="badge badge-pill badge-primary total-game-contributions">{{ $game->contributions->count() }}</span></a>
		    </li>
		@endif
		<li id="game-menu-relateds" @if($currentRouteName == 'game.relateds') class="active" @endif>
			<a href="{{ route('game.relateds', $game->slug) }}">@lang('game/components/menu.related')</a>
		</li>
	</ul>
	<div class="clearfix"></div>
</section>