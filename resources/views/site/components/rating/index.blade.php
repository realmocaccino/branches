@if($errors->all())
	{{ print_r($errors->all()) }}
@endif

<div id="rating" @if(Site::getPreviousRouteName() == 'game.index' and !$game->ratings()->count()) data-reload="true" @endif>
	@include('site.components.rating.header')
	<div id="rating-body">
		<form id="rating-form" method="post" action="{{ route('rating.save', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.save', $game->slug) }}">
			<fieldset>
			    @if($user->isNewcomer())
			        <div class="rating-instructions alert alert-secondary">@lang('components/rating/index.slide_the_buttons')</div>
			    @elseif($game->isClassic())
					<div class="rating-instructions alert alert-info">@lang('components/rating/index.rate_according_to_the_time')</div>
		        @endif
				<div id="rating-criterias">
					@foreach($game->criterias as $criteria)
						<?php $criteriaScore = (isset($rating) and $rating->scores->where('criteria_id', $criteria->id)->first()) ? $rating->scores->where('criteria_id', $criteria->id)->first()->value : $defaultScore; ?>
						<div class="rating-criteria">
							<div class="rating-criteria-left">
								<div class="rating-criteria-hint" title="{{ $criteria->description }}" data-tooltip-mobile="true"></div>
								<label class="rating-criteria-name" title="{{ $criteria->description }}" data-tooltip-mobile="true" for="{{ $criteria->slug }}">{{ $criteria->name }}</label>
								<div class="rating-criteria-input">
									<input
										type="range"
										min="{{ $minimumScore }}"
										max="{{ $maximumScore }}"
										step="{{ $scoreInterval }}"
										name="criterias[{{ $criteria->slug }}]"
										value="{{ $criteriaScore }}"
										data-weight="{{ $criteria->weight }}"
										data-slug="{{ $criteria->slug }}">
								</div>
							</div>
							<div class="rating-criteria-score">
								@component('site.components.item.score', [
									'score' => $criteriaScore,
									'class' => 'rating-criteria-score-size'
								])
								@endcomponent
							</div>
						</div>
					@endforeach
				</div>
				<div id="rating-chart">
					@if(!$agent->isMobile())
						<canvas id="rating-chart-canvas" width="160" height="120" data-chart='@json(['datasets' => $chartDatasets, 'labels' => $chartLabels])'></canvas>
					@endif
				</div>
				<div id="rating-bottom">
					<select id="rating-platform" name="platform_id" class="form-control" required="required">
						<option value="" disabled="disabled" selected="selected">@lang('components/rating/index.which_platform_have_you_played')</option>
						@foreach($game->platforms as $platform)
							<option value="{{ $platform->id }}" data-img="{{ $platform->getLogo() }}" @if($game->platforms->count() == 1 or (isset($rating) and $rating->platform_id == $platform->id) or (!isset($rating) and $user->platform_id == $platform->id)) selected="selected" @endif>{{ $platform->name }}</option>
						@endforeach
					</select>
					<div id="rating-bottom-score">
						@component('site.components.item.score', [
							'score' => isset($rating) ? $rating->score : '5.0',
							'class' => 'game-score-size'
						])
						@endcomponent
					</div>
					<button type="submit" id="rating-button" class="btn btn-block btn-primary">@lang('components/rating/index.conclude')</button>
					@isset($rating)
						<a id="rating-bottom-delete" class="dialog" href="{{ route('rating.delete', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.delete', $game->slug) }}">@lang('components/rating/index.deleteRating')</a>
					@endisset
				</div>
				<input type="hidden" name="origin_route" value="{{ Site::getPreviousRouteName() }}">
				{!! csrf_field() !!}
			</fieldset>
		</form>
	</div>
</div>