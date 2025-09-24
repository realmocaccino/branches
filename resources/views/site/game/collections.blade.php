@extends('site.layouts.game.open')

@section('internal_content')

    <div class="row" id="game-collections-page">
	    <div class="col-12">
	        @if($collections->count())
	            @component('site.components.title', [
	                'title' => trans('game/collections.collections')
                ])
                @endcomponent
                <div class="listing listing-fourColumns">
	                <ul class="listing-items">
		                @foreach($collections as $collection)
			                <li>@include('site.components.item.collection')</li>
		                @endforeach
	                </ul>
	                <div class="listing-pagination">
		                {{ $collections->links() }}
		            </div>
                </div>
            @endif
	    </div>
    </div>

@endsection