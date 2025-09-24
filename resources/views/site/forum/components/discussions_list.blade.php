<table id="forum-discussionsList" class="table table-striped">
	<tr>
		<th width="27%">@lang('forum/components/discussions_list.title')</th>
		@if($currentRouteName != 'game.forum.index')
			<th width="21%">@lang('forum/components/discussions_list.game')</th>
		@endif
		<th width="14%">@lang('forum/components/discussions_list.by')</th>
		@if(!isset($short) or !$short)
			<th width="18%">@lang('forum/components/discussions_list.date')</th>
			<th width="10%" class="text-center">@lang('forum/components/discussions_list.answers')</th>
		@endif
	</tr>
	@foreach($discussions as $discussion)
	    <tr>
		    <td><a title="@lang('forum/components/discussions_list.see_discussion')" href="{{ $discussion->game ? route('game.forum.discussion', [$discussion->game->slug, $discussion->id]) : route('forum.discussion', [$discussion->id]) }}" style="border-bottom: 1px solid #444;">{{ $discussion->title }}</a></td>
		    @if($currentRouteName != 'game.forum.index')
			    <td>@if($discussion->game)<a title="@lang('forum/components/discussions_list.see_game')" href="{{ route('game.forum.index', [$discussion->game->slug]) }}">{{ $discussion->game->name }}</a>@else [@lang('forum/components/discussions_list.offGame')] @endif</td>
		    @endif
		    <td>
		        <a title="@lang('forum/components/discussions_list.see_user')" href="{{ route('user.index', [$discussion->user->slug]) }}">{{ $discussion->user->name }}</a>
		    </td>
		    @if(!isset($short) or !$short)
			    <td>{{ $discussion->created_at->format('d/m/Y à\s h:i') }}</td>
			    <td class="text-center"><a title="@lang('forum/components/discussions_list.see_answers')" href="{{ $discussion->game ? route('game.forum.discussion', [$discussion->game->slug, $discussion->id]) : route('forum.discussion', [$discussion->id]) }}">{{ $discussion->answers()->count() }}</a></td>
		    @endif
	    </tr>
	@endforeach
</table>