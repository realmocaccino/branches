@extends('site.layouts.internal.index')

@section('internal_counter')
    
    <a class="btn btn-success" href="{{ route('collection.index', [$collection->user->slug, $collection->slug]) }}">@lang('collection/order.conclude')</a>
    
@endsection

@section('internal_content')

    <div class="row listing listing-games listing-tenColumns" id="collection-orderPage">
        <div class="col-12">
		    <ul class="listing-items sortable" data-ajax-url="{{ route('collection.ajax.order', [$collection->slug]) }}">
			    @foreach($collection->games as $game)
				    <li data-id="{{ $game->id }}">@include('site.components.item.game_raw')</li>
			    @endforeach
		    </ul>
        </div>
    </div>

@endsection