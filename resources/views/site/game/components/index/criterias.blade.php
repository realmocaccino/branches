<section id="game-index-criterias">
	<div class="row">
		<div class="col-12">
			@component('site.components.title', [
				'title' => trans('game/components/index/criteriasChart.title')
			])
			@endcomponent
		</div>
	</div>
	<div class="row">
        <div class="col-12">
			<div class="row">
				<div class="col-12 order-lg-1 order-2">
					@if(!$game->isExclusive())
						<select id="game-index-criterias-filterByPlatformList" data-ajax-url="{{ route('game.ajax.getCriteriasScoresByPlatform', $game->slug) }}">
							<option value="">@lang('game/components/index/criteriasChart.filter_by_platform')</option>
							@foreach($game->platforms(false)->orderBy('pivot_total', 'desc')->get() as $platform)
								<option value="{{ $platform->slug }}" data-img="{{ $platform->getLogo() }}" @if(!$platform->pivot->score) disabled="disabled" title="@lang('game/components/index/criteriasChart.no_ratings_yet')" @endif>
									{{ $platform->name }}
								</option>
							@endforeach
						</select>
					@endif
				</div>
				<div class="col-12 order-lg-2 order-1">
					<canvas id="game-index-criterias-chart" width="360" height="<?php echo $agent->isMobile() ? 300 : 240; ?>" data-chart='{!! json_encode(['datasets' => $datasets, 'labels' => $game->criterias->pluck('name')]) !!}'></canvas>
				</div>
			</div>
		</div>
	</div>
</section>