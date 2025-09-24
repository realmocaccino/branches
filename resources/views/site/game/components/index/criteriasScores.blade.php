<section id="game-index-criteriasScores">
	<div class="row">
		<div class="col-12">
			@component('site.components.title', [
				'title' => trans('game/components/index/criteriasScores.title')
			])
			@endcomponent
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<table id="game-index-criteriasScores-table" class="table table-hover">
				@isset($userRating)
					<tr id="game-index-criteriasScores-table-labels">
						<th width="60%"></th>
						<th width="20%" class="text-center">@lang('game/components/index/criteriasScores.mine')</th>
						<th width="20%" class="text-center">@lang('game/components/index/criteriasScores.community')</th>
					</tr>
				@endisset
				@foreach($game->criterias as $criteria)
					<tr class="game-index-criteriasScores-table-criteriaRow">
						<td>
							<span class="game-index-criteriasScores-table-criteriaRow-name" title="{{ $criteria->description }}" data-tooltip-mobile="true">{{ $criteria->name }}</span>
							<img class="game-index-criteriasScores-table-criteriaRow-hint" title="{{ $criteria->description }}" data-tooltip-mobile="true" src="{{ asset('img/info.png') }}">
						</td>
						@isset($userRating)
							<td class="text-center">
								@component('site.components.item.score', [
									'score' => optional($userRating->scores()->whereCriteriaId($criteria->id)->first())->value
								])
								@endcomponent
							</td>
						@endisset
						<td class="@isset($userRating) text-center @else text-right @endif">
							@component('site.components.item.score', [
								'score' => (!isset($platformId) or !$platformId) ? $criteria->pivot->score : ScoreHelper::getGameCriteriaScoreByPlatform($game, $criteria->id, $platformId)
							])
							@endcomponent
						</td>
					</tr>
				@endforeach
			</table>
		</div>
	</div>
</section>