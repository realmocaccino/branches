@extends('site.layouts.internal.index')

@section('internal_content')

	<div id="feed">
		<div class="row" id="feed-filter">
			<div class="col-12">
				@include('site.feed.components.menu')
			</div>
		</div>
		<div class="row" id="feed-content">
			<div class="col-12">
				@if(isset($feed))
					@if($feed->count())
						<div class="listing
							@switch($filterBy)
								@case('ratings')
									listing-fiveColumns
								@break
								@case('reviews')
									listing-fourColumns
								@break
								@case('collections')
									listing-fourColumns
								@break
								@case('contributions')
									listing-fiveColumns
								@break
								@case('reviewFeedbacks')
									listing-fourColumns
								@break
								@case('follows')
									listing-fiveColumns
								@break
								@case('likes')
									listing-fiveColumns
								@break
								@case('wants')
									listing-fiveColumns
								@break
								@default
									listing-fiveColumns
							@endswitch
						">
							<ul class="listing-items">
								@foreach($feed as $activity)
									@if($activity->user or $activity->follower)
										<li>
											@include('site.feed.components.activity', [
												'activity' => $activity
											])
										</li>
									@endif
								@endforeach
							</ul>
							<div class="listing-pagination">
								{{ $feed->links('pagination::simple-bootstrap-4') }}
							</div>
						</div>
					@else
						<div id="feed-noResults">
							@include('site.components.neutral_face')
							<p class="descriptive">@lang('feed/index.no_activities')</p>
						</div>
					@endif
				@elseif(isset($noFollowings) and $noFollowings)
					<div id="feed-noFollowings">
						@include('site.components.neutral_face')
						<p class="descriptive">@lang('feed/index.no_followings')</p>
					</div>
				@endif
			</div>
		</div>
	</div>

@endsection