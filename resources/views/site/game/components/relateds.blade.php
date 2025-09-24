@if(count($relateds))
	<section id="game-relateds" class="listing listing-oneColumn">
		@component('site.components.title', [
			'title' => trans('game/components/relateds.title'),
			//'link' => route('game.relateds', $game->slug),
			'arrow' => true
		])
		@endcomponent
		<ul class="listing-items">
			@foreach($relateds as $related)
				<li>
					@component('site.components.item.game_horizontal', [
						'game' => $related
					])
					@endcomponent
				</li>
			@endforeach
		</ul>
	</section>
@endif