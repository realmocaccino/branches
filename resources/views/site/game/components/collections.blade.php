@if($latestCollections->count())
    <section id="game-collections" class="listing listing-{{ $columnsPerRow ?? 'one' }}Columns">
	    @component('site.components.title', [
		    'title' => trans('game/components/collections.title') . $game->name,
		    'link' => route('game.collections', $game->slug),
		    'arrow' => true
	    ])
	    @endcomponent
	    <ul class="listing-items">
            @foreach($latestCollections as $collection)
                <li>
	                @component('site.components.item.collection', [
                        'collection' => $collection
                    ])
                    @endcomponent
                </li>
            @endforeach
	    </ul>
    </section>
@endif