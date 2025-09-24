@extends('site.layouts.forum.index')

@section('forum_content')

	<div id="forum-create">
		@component('site.components.title', [
			'title' => trans('forum/create.create_discussion')
		])
		@endcomponent
		@auth('site')
			@component('site.forum.components.create_discussion_form', [
				'game' => isset($game) ? $game : null
			])
			@endcomponent
		@else
			<p><a href="{{ route('login.index') }}" class="underscore">@lang('forum/create.do_login')</a> @lang('forum/create.to_start_a_discussion')</p>
		@endauth
	</div>

@endsection
