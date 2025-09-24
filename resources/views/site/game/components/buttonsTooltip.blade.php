
@if($game->isAvailable())
    @if($addedToPlaying)
        <a class="game-buttons-collections-tooltip-button btn btn-info" href="{{ route('collection.remove', [$game->slug, 'playing']) }}" data-ajax-url="{{ route('collection.ajax.remove', [$game->slug, 'playing']) }}">
        <em class="fa fa-check"></em> @lang('game/components/buttonsCollections.removeFromPlaying') <span class="badge badge-primary">{{ $totalPlaying }}</span>
        </a>
    @else
        <a class="game-buttons-collections-tooltip-button btn btn-outline-info" href="{{ route('collection.add', [$game->slug, 'playing']) }}" data-ajax-url="{{ route('collection.ajax.add', [$game->slug, 'playing']) }}">
            <em class="fa fa-gamepad"></em> @lang('game/components/buttonsCollections.addToPlaying') <span class="badge badge-primary">{{ $totalPlaying }}</span>
        </a>
    @endif
@endif
@if($favorited)
    <a class="game-buttons-collections-tooltip-button btn btn-site" href="{{ route('collection.remove', [$game->slug, 'favorites']) }}" data-ajax-url="{{ route('collection.ajax.remove', [$game->slug, 'favorites']) }}">
        <em class="fa fa-check"></em> @lang('game/components/buttonsCollections.unfavorite') <span class="badge badge-primary">{{ $totalFavorites }}</span>
    </a>
@else
    <a class="game-buttons-collections-tooltip-button btn btn-outline-site" href="{{ route('collection.add', [$game->slug, 'favorites']) }}" data-ajax-url="{{ route('collection.ajax.add', [$game->slug, 'favorites']) }}">
        <em class="fa fa-heart"></em> @lang('game/components/buttonsCollections.favorite') <span class="badge badge-primary">{{ $totalFavorites }}</span>
    </a>
@endif
@if($wishlisted)
    <a class="game-buttons-collections-tooltip-button btn btn-success" href="{{ route('collection.remove', [$game->slug, 'wishlist']) }}" data-ajax-url="{{ route('collection.ajax.remove', [$game->slug, 'wishlist']) }}">
        <em class="fa fa-check"></em> @lang('game/components/buttonsCollections.removeFromWishlist') <span class="badge badge-primary">{{ $totalInWishlist }}</span>
    </a>
@else
    <a class="game-buttons-collections-tooltip-button btn btn-outline-success" href="{{ route('collection.add', [$game->slug, 'wishlist']) }}" data-ajax-url="{{ route('collection.ajax.add', [$game->slug, 'wishlist']) }}">
        <em class="fa fa-plus"></em> @lang('game/components/buttonsCollections.addToWishlist') <span class="badge badge-primary">{{ $totalInWishlist }}</span>
    </a>
@endif
@auth('site')
    @foreach($userCustomCollections as $collection)
        @if($collection->isGameInTheCollection)
            <a class="game-buttons-collections-tooltip-button btn btn-primary" href="{{ route('collection.remove', [$game->slug, $collection->slug]) }}" data-ajax-url="{{ route('collection.ajax.remove', [$game->slug, $collection->slug]) }}">
                <em class="fa fa-check"></em> {{ $collection->name }}
            </a>
        @else
            <a class="game-buttons-collections-tooltip-button btn btn-outline-primary" href="{{ route('collection.add', [$game->slug, $collection->slug]) }}" data-ajax-url="{{ route('collection.ajax.add', [$game->slug, $collection->slug]) }}">
                <em class="fa fa-plus"></em> {{ $collection->name }}
            </a>
        @endif
    @endforeach
@endauth
<form id="game-buttons-collections-tooltip-createCollectionForm" method="post" action="{{ route('collection.create', $game->slug) }}" data-ajax-url="{{ route('collection.ajax.create', $game->slug) }}">
    <input id="game-buttons-collections-tooltip-createCollectionForm-input" placeholder="@lang('game/components/buttonsCollections.newCollection')" type="text" name="name" required>
    <button id="game-buttons-collections-tooltip-createCollectionForm-button" type="submit" class="btn btn-primary">
        <span id="game-buttons-collections-tooltip-createCollectionForm-createText">@lang('game/components/buttonsCollections.createNewCollection')</span> <em class="fa fa-arrow-right"></em>
    </button>
    {{ csrf_field() }}
</form>
<span id="game-buttons-collections-totalCollectionsChecked" data-value="{{ $totalInCollections }}"></span>