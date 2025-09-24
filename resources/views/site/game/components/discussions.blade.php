<section id="game-discussions">
	@component('site.components.title', [
		'title' => trans('game/components/discussions.title'),
		'class' => 'float-left'
	])
	@endcomponent
	@if($latestDiscussions->count())
		@component('site.forum.components.create_btn', [
			'game' => $game
		])
		@endcomponent
		@component('site.forum.components.discussions_list', [
			'discussions' => $latestDiscussions
		])
		@endcomponent
		@if($game->discussions->count() > $latestDiscussionsLimit)
			<a id="game-discussions-more" class="btn btn-block btn-site" href="{{ route('game.forum.index', $game->slug) }}">@lang('game/components/discussions.see_all_discussions')</a>
		@endif
	@else
		<p id="game-discussions-firstToDiscuss">@lang('game/components/discussions.be_the_first') <a class="underscore" href="{{ route('game.forum.create', $game->slug) }}">@lang('game/components/discussions.create_discussion')</a></p>
	@endif
</section>