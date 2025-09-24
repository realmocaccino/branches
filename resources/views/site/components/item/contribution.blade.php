<div class="item-contribution">
    @if(!isset($cover) or $cover == 'game_user')
	    @component('site.components.item.user_picture', [
            'user' => $contribution->user,
            'size' => '48x60'
        ])
        @endcomponent
        @component('site.components.item.game_picture', [
            'game' => $contribution->game,
            'size' => '48x60'
        ])
        @endcomponent
    @elseif($cover == 'user')
	    @component('site.components.item.user_picture', [
            'user' => $contribution->user,
            'size' => '48x60'
        ])
        @endcomponent
    @elseif($cover == 'game')
	    @component('site.components.item.game_picture', [
            'game' => $contribution->game,
            'size' => '48x60'
        ])
        @endcomponent
    @endif
    <div class="item-contribution-info">
        <p class="item-contribution-info-description">{{ $contribution->user->name }} @lang('components/item/contribution.' . $contribution->type) <a class="underscore" href="{{ route('game.index', ['gameSlug' => $contribution->game->slug]) }}">{{ $contribution->game->name }}</a></p>
        <p class="item-contribution-info-date descriptive">{{ $contribution->created_at->diffForHumans() }}</p>
    </div>
</div>