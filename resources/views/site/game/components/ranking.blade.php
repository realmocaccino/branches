@if(count($games))
    <section id="game-ranking" class="listing listing-oneColumn">
        @component('site.components.title', [
            'title' => trans('game/components/ranking.title') . $game->release->year,
            'link' => route('ranking.games', $game->release->year),
            'arrow' => true
        ])
        @endcomponent
        <ul class="listing-items">
            @foreach($games as $game)
                <li>
                    <div class="rankingPosition">{{ $game->position }}</div>
                    @component('site.components.item.game_horizontal', [
                        'game' => $game
                    ])
                    @endcomponent
                </li>
            @endforeach
        </ul>
    </section>
@endif