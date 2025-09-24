<a class="item-game-carousel" href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
    <div class="item-game-image">
		<img src="{{ $game->getBackground($agent->isMobile() ? '576x324' : '1920x1080') }}">
	</div>
	<div class="item-game-border"></div>
	<div class="item-game-data">
		<div class="item-game-name @if(strlen($game->name) > 35) name-too-long @endif">
			{{ $game->name }}
		</div>
		@if($game->description)
		    <div class="item-game-description">
			    {{ str_limit($game->description, 140, '...') }}
		    </div>
		@endif
	</div>
	<div class="item-game-score">
		@if($game->score)
			@component('site.components.item.score', [
				'score' => $game->score,
				'class' => 'game-spotlight-score-size'
			])
			@endcomponent
		@elseif(!$game->isAvailable())
			<span class="item-game-score-daysToRelease badge badge-primary">
				@if(!$game->isUndated())
					{{ $game->countdownByDays() }} {{ str_plural(trans('components/item/game_slide.day'), $game->countdownByDays()) }}
				@else
					@lang('components/item/game_slide.no_date')
				@endif
			</span>
		@endif
	</div>
</a>