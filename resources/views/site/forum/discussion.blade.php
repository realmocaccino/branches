@extends('site.layouts.forum.index')

@section('forum_content')

	<div id="forum-discussion">
		<a href="{{ (isset($game) and Site::getPreviousRouteName() != 'forum.index') ? route('game.forum.index', [$game->slug]) : route('forum.index') }}" class="btn btn-sm btn-link">&#171; @lang('forum/discussion.all_discussions')</a>
		<div id="forum-discussion-question">
			<h2><a href="{{ isset($game) ? route('game.forum.discussion', [$game->slug, $discussion->id]) : route('forum.discussion', [$discussion->id]) }}">{{ $discussion->title }}</a></h2>
			@component('site.forum.components.item_answer', [
				'entity' => $discussion
			])
			@endcomponent
		</div>
		<div id="forum-discussion-answers">
			@if($answers->count())
				@foreach($answers as $answer)
					@component('site.forum.components.item_answer', [
						'entity' => $answer
					])
					@endcomponent
				@endforeach
				{{ $answers->links() }}
			@endif
		</div>
		@auth('site')
			<h4>@lang('forum/discussion.answer_the_discussion')</h4>
			@component('site.forum.components.create_answer_form', [
				'game' => isset($game) ? $game : null,
				'discussion' => $discussion
			])
			@endcomponent
		@else
			<p><a href="{{ route('login.index') }}" class="underscore">@lang('forum/discussion.do_login')</a> @lang('forum/discussion.to_answer_the_discussion')</p>
		@endif
	</div>

@endsection
