<?php
$withScore = (!isset($withoutScore) or !$withoutScore);
$gameCover = $game->getCover($coverSize ?? '250x');
?>
<div class="item-game @if(!$withScore or $game->isUndated() or $currentRouteName == 'collection.index') item-gameWithoutScore @endif">
	<a class="item-game-link" href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
		<div class="item-game-image">
			<img src="{{ $gameCover }}" data-splide-lazy="{{ $gameCover }}">
		</div>
		<div class="item-game-data">
			<div class="item-game-name">
				{{ str_limit($game->name, $nameLimit ?? 9999) }}
			</div>
			<div class="item-game-release">
			    @if(!$game->isUndated())
				    @if(isset($isExtensiveRelease) and $isExtensiveRelease)
		                @if($game->release->isFuture())
		                    {{ $game->extensiveDate() }}
		                @else
		                    {{ $game->release->diffForHumans() }}
		                @endif
				    @else
				        {{ $game->release->year }}
				    @endif
			    @else
                    @lang('components/item/game.no_date')
                @endif
            </div>
			@if($withScore and !$game->isUndated() and $currentRouteName != 'collection.index')
			    <div class="item-game-score">
	                @if($game->score)
		                @component('site.components.item.score', [
			                'score' => $game->score
		                ])
		                @endcomponent
	                @elseif($game->isAvailable())
		                <object>
		                    <a class="add-score dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}" title="@lang('components/item/game.add_score')">
			                    <span class="oi oi-plus"></span>
		                    </a>
		                </object>
	                @else
	                    <span class="badge badge-big badge-primary">
                            {{ $game->countdownByDays() }} {{ str_plural(trans('components/item/game.day'), $game->countdownByDays()) }}
	                    </span>
                    @endif
                </div>
            @endif
		</div>
    </a>
    @if(isset($removeFromCollection) and $removeFromCollection)
        <a class="badge badge-big badge-danger" href="{{ route('collection.remove', ['gameSlug' => $game->slug, 'collectionSlug' => request()->route('collectionSlug')]) }}">@lang('components/item/game.remove')</a>
    @endif
</div>