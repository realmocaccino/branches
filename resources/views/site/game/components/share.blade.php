<section id="game-share">
	<p><strong>@lang('game/components/share.share'):</strong></p>
	<ul id="game-share-list">
		@if($agent->isMobile())
			<li>
				@component('site.components.social.item', [
					'network' => 'whatsapp',
					'url' => 'whatsapp://send?text=' . $defaultDescription . ' ' . route('game.index', [$game->slug]),
					'title' => 'WhatsApp',
					'size' => 'extra-small'
				])
				@endcomponent
			</li>
		@endif
		<li>
			@component('site.components.social.item', [
				'network' => 'twitter',
				'url' => 'https://twitter.com/intent/tweet?text=' . $defaultDescription . '&url=' . route('game.index', [$game->slug]),
				'title' => 'Twitter',
				'size' => 'extra-small'
			])
			@endcomponent
		</li>
		<li>
			@component('site.components.social.item', [
				'network' => 'facebook',
				'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . route('game.index', [$game->slug]),
				'title' => 'Facebook',
				'size' => 'extra-small'
			])
			@endcomponent
		</li>
	</ul>
</section>