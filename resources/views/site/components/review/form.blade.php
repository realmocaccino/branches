<form class="review-write-form" method="post" action="{{ route('review.save', $rating->game->slug) }}" data-ajax-url="{{ route('review.ajax.save', $rating->game->slug) }}">
	<fieldset class="review-write-form-fieldset">
		<textarea class="review-write-form-textarea" name="text" placeholder="@lang('components/review/form.write_your_review_to') {{ $rating->game->name }}" required>{{ old('text', Site::filterReviewText(optional($rating->review)->text)) }}</textarea>
		<div class="review-write-form-info">
			@component('site.components.item.score', [
				'classic' => 'true',
				'score' => $rating->score
			])
			@endcomponent
			@lang('components/review/form.on') @include('site.components.item.platform', ['platform' => $rating->platform])
		</div>
		<div class="review-write-form-actions">
		    <label class="review-write-form-hasSpoilers-label"><input class="review-write-form-hasSpoilers" type="checkbox" name="has_spoilers" value="1" @if($rating->review and $rating->review->has_spoilers) checked="checked" @endif> @lang('components/review/form.has_spoilers')</label>
		    @if($rating->review)
			    <span class="review-write-form-cancel btn btn-link">@lang('components/review/form.cancel')</span>
		    @endif
		    <input class="review-write-form-submit btn btn-sm btn-site" type="submit" value="@lang('components/review/form.send')">
		</div>
		{{ csrf_field() }}
	</fieldset>
</form>