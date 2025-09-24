@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-reviews">{{ $total }}</span></strong> @lang('user/reviews.reviews')
	@elseif($total == 1)
		<strong><span class="total-user-reviews">1</span></strong> @lang('user/reviews.review')
	@else
		@lang('user/reviews.no_reviews')
	@endif
	
@endsection

@section('user_content')

	<div id="user-reviews">
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
		<div class="row listing listing-twoColumns listing-reviews">
			<div class="col-12">
			    @if($total)
				    <ul class="listing-items">
					    @foreach($reviews as $review)
						    <li>@include('site.components.item.review', [
							    'cover' => 'game',
							    'slide' => !$agent->isMobile()
						    ])</li>
					    @endforeach
				    </ul>
				    <div class="listing-pagination">
					    {{ $reviews->links() }}
				    </div>
			    @else
			        <div class="listing-noResults">
			            @include('site.components.neutral_face', [
		                    'size' => 'big'
		                ])
		                <p>@lang('listing/reviews.no_review_found')</p>
		                @if($filter['actives'])
		                    <p>{!! end($filter['actives']) !!}</p>
		                @endif
		            </div>
			    @endif
			</div>
		</div>
	</div>

@endsection