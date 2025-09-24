<?php $withScore = (!isset($withoutScore) or !$withoutScore); ?>
<div class="item-game-short @if(!$withScore or $game->isUndated()) item-game-shortWithoutScore @endif">
	<a class="item-game-link" href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
		<div class="item-game-image">
			<img src="{{ $game->getCover('78x90') }}">
		</div>
		<div class="item-game-data">
			<div class="item-game-name @if(strlen($game->name) > 26) name-too-long @endif">
				{{ str_limit($game->name, $nameLimit ?? 9999) }}
			</div>
			<div class="item-game-release">
			    @if(!$game->isUndated())
				    {{ $game->release->format('Y') }}
				@else
				    @lang('components/item/game.no_date')
				@endif
			</div>
		</div>
	</a>
	@if($withScore and !$game->isUndated())
	    <div class="item-game-score">
		    @if($game->score)
			    <a href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
				    @component('site.components.item.score', [
					    'score' => $game->score
				    ])
				    @endcomponent
			    </a>
		    @elseif($game->isAvailable())
			    <a class="add-score dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}" title="@lang('components/item/game.add_score')">
				    <span class="oi oi-plus"></span>
			    </a>
		    @else
		        <span class="badge badge-big badge-primary">
				    {{ $game->countdownByDays() }} {{ str_plural(trans('components/item/game.day'), $game->countdownByDays()) }}
		        </span>
	        @endif
	    </div>
	@endif
</div>