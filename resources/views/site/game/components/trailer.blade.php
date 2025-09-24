@if($game->trailer)
    <section id="game-trailer">
        @component('site.game.components.title', [
            'title' => trans('game/components/trailer.title')
        ])
        @endcomponent
	    @component('site.components.item.trailer', [
	        'youtubeId' => $game->trailer,
	        'autoplay' => isset($autoplay) and $autoplay
        ])
        @endcomponent
    </section>
@endif