@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-reviews">{{ $total }}</span></strong> @lang('user/likedReviews.reviews')
	@elseif($total == 1)
		<strong><span class="total-user-reviews">1</span></strong> @lang('user/likedReviews.review')
	@else
		@lang('user/likedReviews.no_reviews')
	@endif
	
@endsection

@section('user_content')

	<div id="user-likedReviews">
		@if($feedbacks->count())
			<div class="row listing listing-twoColumns listing-reviews">
				<div class="col-12">
					<ul class="listing-items">
						@foreach($feedbacks as $feedback)
							<li>
								@component('site.components.item.review', [
									'review' => $feedback->review,
									'cover' => 'game_user'
								])
								@endcomponent
							</li>
						@endforeach
					</ul>
					<div class="listing-pagination">
						{{ $feedbacks->links() }}
					</div>
				</div>
			</div>
		@endif
	</div>

@endsection