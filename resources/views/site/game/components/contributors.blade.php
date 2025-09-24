@if($game->contributions->count())
    <section id="game-contributors">
		@component('site.components.title', [
			'title' => trans('game/components/contributors.title')
		])
		@endcomponent
		<ul>
			@foreach($game->contributions()->get() as $contribution)
				<li>
					@component('site.components.item.user_picture', [
						'user' => $contribution->user,
						'size' => '150x150'
					])
					@endcomponent
				</li>
			@endforeach
		</ul>
    </section>
@endif