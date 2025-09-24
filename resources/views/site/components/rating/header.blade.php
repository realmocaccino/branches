<div id="rating-header">
	@component('site.components.item.game_picture', [
		'game' => $game,
		'size' => '110x136'
	])
	@endcomponent
	<div id="rating-header-score">
		@component('site.components.item.score', [
			'score' => isset($rating) ? $rating->score : $defaultScore,
			'class' => 'game-score-size'
		])
		@endcomponent
	</div>
</div>