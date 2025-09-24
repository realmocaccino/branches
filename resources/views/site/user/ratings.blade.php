@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-ratings">{{ $total }}</span></strong> @lang('user/ratings.ratings')
	@elseif($total == 1)
		<strong><span class="total-user-ratings">1</span></strong> @lang('user/ratings.rating')
	@else
		@lang('user/ratings.no_ratings')
	@endif
	
@endsection

@section('user_content')

	<div id="user-ratings">
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
					    @foreach($ratings as $rating)
						    <li>@include('site.components.item.rating')</li>
					    @endforeach
				    </ul>
				    <div class="listing-pagination">
					    {{ $ratings->links() }}
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
	</div>

@endsection