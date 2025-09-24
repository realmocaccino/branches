<div class="item-review-extended item-review-{{ $review->id }}">
	<div class="item-review-extended-header">
		<div class="item-review-extended-header-data descriptive">
			@if(!isset($cover) or $cover == 'user')
				@component('site.components.item.user_picture', [
					'user' => $review->user,
					'size' => '48x60'
				])
				@endcomponent
				<a class="item-review-extended-user-name" href="{{ route('user.index', [$review->user->slug]) }}" title="@lang('components/item/review.see_profile_of') {{ $review->user->name }}">{{ $review->user->name }}</a>
			@elseif($cover == 'game')
				@component('site.components.item.game_picture', [
					'game' => $review->game,
					'size' => '78x90'
				])
				@endcomponent
				<a class="item-review-extended-game-name" href="{{ route('game.index', [$review->game->slug]) }}" title="@lang('components/item/review.see_rating_of') {{ $review->game->name }}">{{ $review->game->name }}</a>
			@elseif($cover == 'game_user')
				@component('site.components.item.game_picture', [
					'game' => $review->game,
					'size' => '78x90'
				])
				@endcomponent
				@component('site.components.item.user_picture', [
					'user' => $review->user,
					'size' => '48x60'
				])
				@endcomponent
				<a class="item-review-extended-user-name" href="{{ route('user.index', [$review->user->slug]) }}">{{ $review->user->name }}</a> @lang('components/item/review.to')
				<a class="item-review-extended-game-name" href="{{ route('game.index', [$review->game->slug]) }}">{{ $review->game->name }}</a>
			@endif
			<div class="item-review-extended-header-data-bottom">
				@lang('components/item/review.on')
				<div class="item-review-extended-platform">
					@include('site.components.item.platform', [
						'platform' => $review->platform,
						'logoSize' => '32x32'
					])
				</div>
				<span class="item-review-extended-date">{{ $review->updated_at->diffForHumans() }}</span>
			</div>
		</div>
		<div class="item-review-extended-header-score">
			@component('site.components.item.score', [
				'score' => $review->rating->score
			])
			@endcomponent
		</div>
	</div>
	<div class="clearfix"></div>
	<hr>
	<div class="item-review-extended-criterias">
		@foreach($review->scores as $score)
			<div class="item-review-extended-criterias-criteria">
				<table class="table table-responsive">
					<tr>
						<td class="align-middle"><strong>{{ $score->criteria->name }}</strong></td>
						<td class="text-right">
							@component('site.components.item.score', [
								'score' => $score->value,
								'class' => 'small-score-size'
							])
							@endcomponent
						</td>
					</tr>
				</table>
			</div>
		@endforeach
	</div>
	<hr>
	<div class="item-review-extended-body">
	    @if($review->has_spoilers) <p class="item-review-extended-hasSpoilers">@lang('components/item/review.hasSpoilers')</p> @endif
		<div class="item-review-extended-text" data-has-spoilers="{{ $review->has_spoilers }}" data-sumup="5"><span class="fa fa-quote-left"></span> {!! Site::filterReviewText($review->text) !!} <span class="fa fa-quote-right"></span></div>
		<hr>
		<div class="item-review-extended-footer">
			@if(Auth::guard('site')->id() == $review->user->id)
				<div class="item-review-extended-actions">
					<a class="item-review-extended-edit">
						<span class="badge badge-big badge-primary">@lang('components/item/review.edit')</span>
					</a>
					<a class="item-review-extended-delete" href="{{ route('review.delete', $review->game->slug) }}" data-ajax-url="{{ route('review.ajax.delete', $review->game->slug) }}">
						<span class="badge badge-big badge-danger" data-message="@lang('components/item/review.are_you_sure')">@lang('components/item/review.delete')</span>
					</a>
				</div>
			@endif
			<div class="item-review-extended-share">
				<p><strong>@lang('components/item/review.share'):</strong></p>
				<ul class="item-review-extended-share-list">
					@if($agent->isMobile())
						<li>
							@component('site.components.social.item', [
								'network' => 'whatsapp',
								'url' => 'whatsapp://send?text=' . route('game.review', [$review->game->slug, $review->user->slug]),
								'title' => 'WhatsApp',
								'size' => 'extra-small'
							])
							@endcomponent
						</li>
					@endif
					<li>
						@component('site.components.social.item', [
							'network' => 'twitter',
							'url' => 'https://twitter.com/intent/tweet?url=' . route('game.review', [$review->game->slug, $review->user->slug]),
							'title' => 'Twitter',
							'size' => 'extra-small'
						])
						@endcomponent
					</li>
					<li>
						@component('site.components.social.item', [
							'network' => 'facebook',
							'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . route('game.review', [$review->game->slug, $review->user->slug]),
							'title' => 'Facebook',
							'size' => 'extra-small'
						])
						@endcomponent
					</li>
				</ul>
			</div>
			<div class="item-review-extended-feedback" @if(isset($isCached) and $isCached) data-url="{{ route('ajax.feedback.fetch', $review->id) }}" @endif>
				@if(!isset($isCached) or !$isCached)
					@component('site.components.item.review_feedback', [
						'review' => $review
					])
					@endcomponent
				@endif
			</div>
		</div>
	</div>
	@if(Auth::guard('site')->id() == $review->user->id)
		@component('site.components.review.form', [
			'rating' => $review->rating
		])
		@endcomponent
	@endif
</div>