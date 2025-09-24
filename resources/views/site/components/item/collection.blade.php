<div class="item-collection">
    <a href="{{ route('collection.index', [$collection->user->slug, $collection->slug]) }}">
    	<ul class="item-collection-deck">
			@foreach($collection->games()->latest()->take(3)->get() as $game)
				<li>
					<img src="{{ $game->getCover('350x') }}">
				</li>
			@endforeach
		</ul>
    </a>
    <div class="item-collection-info">
        <a class="item-collection-info-nameAndTotal" href="{{ route('collection.index', [$collection->user->slug, $collection->slug]) }}">
            <p class="item-collection-info-name">{{ $collection->name }}</p>
            <p class="item-collection-info-total descriptive">{{ $collection->games->count() }} {{ str_plural(trans('components/item/collection.itens'), $collection->games->count()) }}</p>
        </a>
        @if(!in_array($currentRouteName, ['account.index', 'user.index', 'account.collections', 'user.collections']))
            <div class="item-collection-info-user">
                <div class="item-collection-info-user-picture">
                    @component('site.components.item.user_picture', [
                        'user' => $collection->user,
                        'size' => '34x34'
                    ])
                    @endcomponent
                </div>
                <div class="item-collection-info-user-slug">{{ '@' . $collection->user->slug }}</div>
            </div>
        @endif
        @if($collection->private)
            <span class="item-collection-info-private badge badge-info">@lang('components/item/collection.private')</span>
        @endif
    </div>
</div>