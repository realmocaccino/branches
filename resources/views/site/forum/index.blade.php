@extends('site.layouts.forum.index')

@section('forum_content')

	<div class="row" id="forum-index">
		<div class="col-12">
			@component('site.components.title', [
				'title' => trans('forum/index.discussions'),
				'class' => 'float-left'
			])
			@endcomponent
			@component('site.forum.components.create_btn', [
				'game' => $game ?? null
			])
			@endcomponent
			@if($discussions->count())
				@component('site.forum.components.discussions_list', [
					'discussions' => $discussions
				])
				@endcomponent
			@else
				<p class="clearfix"></p>
				<p id="forum-index-firstToRate">@lang('forum/index.be_the_first_to') <a class="underscore" href="{{ isset($game) ? route('game.forum.create', $game->slug) : route('forum.create') }}">@lang('forum/index.create_a_discussion')</a></p>
			@endif
		</div>
	</div>
	
@endsection