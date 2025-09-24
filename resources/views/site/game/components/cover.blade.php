<section id="game-cover">
	<a id="game-cover-link" href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
		<img id="game-cover-image" itemprop="image" src="{{ $game->getCover('250x') }}" alt="@lang('game/components/cover.cover_of') {{ $game->name }}" title="{{ $game->name }}">
	</a>
</section>