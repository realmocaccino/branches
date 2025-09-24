@extends('site.layouts.internal.index')

@section('internal_counter')

	@isset($total)
		@if($total > 1)
			<strong>{{ $total }}</strong> @lang('listing/games.many_games_found')
		@elseif($total == 1)
			<strong>1</strong> @lang('listing/games.one_game_found')
		@endif
	@endif
	
@endsection

@section('internal_content')

	@if($currentRouteName == 'home')
		@include('site.home.components.search')
    @elseif($currentRouteName == 'collection.index')
        @include('site.collection.inc.info')
    @elseif($currentRouteName == 'discover')
		@include('site.discover.components.search_and_tags')
	@endif
	<div class="row">
        <div class="col-12">
	        @if(isset($filter) and $filter)
				@component('site.helpers.filter', [
					'filter' => $filter
				])
				@endcomponent
			@endisset
        </div>
    </div>
    <div class="row listing listing-games listing-tenColumns">
        <div class="col-12">
	        @if(count($items))
			    <ul class="listing-items">
				    @foreach($items as $game)
					    <li>
						@include('site.components.item.game', [
					        'isExtensiveRelease' => $isExtensiveRelease ?? false,
					        'removeFromCollection' => $removeFromCollection ?? false
					    ])</li>
				    @endforeach
			    </ul>
				@if(method_exists($items, 'links'))
					<div class="listing-pagination">
						{{ $items->links() }}
					</div>
				@endif
			@else
			    <div class="listing-noResults">
			        @include('site.components.neutral_face', [
                        'size' => 'big'
                    ])
                    <p class="descriptive">@lang('listing/games.no_game_found')</p>
                </div>
		    @endif
        </div>
    </div>

@endsection