@extends('site.layouts.internal.index')

@section('internal_counter')

	@if($total > 1)
	    @if(Site::isPageFiltered())
		    <strong>{{ $total }}</strong> @lang('listing/ratings.many_ratings_found')
		@endif
	@elseif($total == 1)
		<strong>1</strong> @lang('listing/ratings.one_rating_found')
	@else
        @lang('listing/ratings.no_rating_found')
	@endif
	
@endsection

@section('internal_content')

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
    <div class="row listing listing-fiveColumns listing-ratings">
	    <div class="col-12">
	        @if($total)
		        <ul class="listing-items">
			        @foreach($items as $rating)
				        <li>@include('site.components.item.rating', [
					        'cover' => 'game_user'
				        ])</li>
			        @endforeach
		        </ul>
		        <div class="listing-pagination">
			        {{ $items->links() }}
		        </div>
	        @else
	            <div class="listing-noResults">
	                @include('site.components.neutral_face', [
                        'size' => 'big'
                    ])
                    <p>@lang('listing/ratings.no_rating_found')</p>
                    @if(isset($filter) and $filter['actives'])
                        <p>{!! end($filter['actives']) !!}</p>
                    @endif
                </div>
	        @endif
	    </div>
	</div>

@endsection