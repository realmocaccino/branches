<div class="item-game item-gameRaw item-gameWithoutScore">
	<div class="item-game-link">
		<div class="item-game-image">
			<img src="{{ $game->getCover($coverSize ?? '250x') }}">
		</div>
		<div class="item-game-data">
			<div class="item-game-name">
				{{ str_limit($game->name, $nameLimit ?? 9999) }}
			</div>
			<div class="item-game-release">
			    @if(!$game->isUndated())
				   {{ $game->release->year }}
			    @else
                    @lang('components/item/game.no_date')
                @endif
            </div>
		</div>
    </div>
</div>