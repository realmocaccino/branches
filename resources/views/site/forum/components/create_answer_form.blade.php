<form id="game-forum-createAnswer-form" method="post" action="{{ isset($game) ? route('game.forum.answerDiscussion', [$game->slug, $discussion->id]) : route('forum.answerDiscussion', [$discussion->id]) }}">
	<div class="form-group">
		<textarea name="text" placeholder="@lang('forum/components/create_answer_form.text_placeholder')" rows="4" class="form-control" required></textarea>
	</div>
	@if($errors->has('text'))
	    <span class="help-block">
	        <strong>{{ $errors->first('text') }}</strong>
	    </span>
	@endif
	<div class="form-group">
		<input type="submit" class="btn btn-success" value="@lang('forum/components/create_answer_form.conclude')">
	</div>
	{{ csrf_field() }}
</form>
