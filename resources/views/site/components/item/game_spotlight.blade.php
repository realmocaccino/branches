<div class="item-game-spotlight" style="background: linear-gradient(#EEE, transparent 300px ), url('{{ $game->getBackground() }}') no-repeat;">
    <h3 class="item-game-spotlight-category">{{ $category }}</h3>
    <div class="item-game-spotlight-game-cover">
        @component('site.components.item.game_picture', [
            'game' => $game,
            'size' => '250x'
        ])
        @endcomponent
    </div>
    <div class="item-game-spotlight-info">
        <p class="item-game-spotlight-game-name"><a href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">{{ $game->name }}</a></p>
        <p class="item-game-spotlight-game-owner">{{ optional($game->owner())->name }}</p>
        <div class="item-game-spotlight-game-description">
            {{ $game->description }}
        </div>
    </div>
</div>