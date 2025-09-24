<a id="game-rate-button" class="btn btn-primary dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}">
    @isset($userRating)
        <span class="fa fa-check"></span> @lang('game/components/buttons.change_score')
    @else 
        @lang('game/components/buttons.add_score')
    @endisset
</a>