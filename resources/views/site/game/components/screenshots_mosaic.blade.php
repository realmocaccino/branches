<section class="game-screenshots">
	@component('site.components.title', [
		'title' => trans('game/components/screenshots.screenshots')
	])
	@endcomponent
	<div class="gg-container" data-gallery>
		<div class="gg-box">
			@foreach($screenshots as $screenshot)
				<a href="{{ $screenshot->getScreenshot($agent->isMobile() ? '640x360' : '1280x720') }}" title="@lang('game/components/screenshots.zoom')">
					<img src="{{ $screenshot->getScreenshot($agent->isMobile() ? '277x157' : '640x360') }}" alt="@lang('game/components/screenshots.screenshot')">
				</a>
			@endforeach
		</div>
	</div>
</section>