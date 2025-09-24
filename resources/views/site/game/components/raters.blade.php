@if($raters->count() or $moreRaters)
    <section id="game-raters">
		@include('site.components.preview', [
			'title' => trans('game/components/raters.title'),
			'link' => route('game.ratings', $game->slug),
			'items' => $raters,
			'thumbnail_view' => 'site.components.item.user_picture',
			'total' => $game->total_ratings
		])
    </section>
@endif