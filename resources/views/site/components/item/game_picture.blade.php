<a class="item-game-picture" href="{{ route('game.index', ['gameSlug' => $game->slug]) }}" title="{{ $game->name }}">
	<img class="item-game-picture-image" src="{{ $game->getCover($size ?? '78x90') }}" alt="@lang('components/item/game_picture.cover_of') {{ $game->name }}">
</a>