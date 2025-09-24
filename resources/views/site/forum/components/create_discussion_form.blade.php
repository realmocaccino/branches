<form id="game-forum-createDiscussion-form" method="post" action="{{ isset($game) ? route('game.forum.createDiscussion', [$game->slug]) : route('forum.createDiscussion') }}">
	<div class="form-group">
		<input type="text" name="title" placeholder="@lang('forum/components/create_discussion_form.title_placeholder')" value="{{ old('title') }}" class="form-control" required>
	</div>
	@if($errors->has('title'))
	    <span class="help-block">
	        <strong>{{ $errors->first('title') }}</strong>
	    </span>
	@endif
	<div class="form-group">
		<textarea name="text" placeholder="@lang('forum/components/create_discussion_form.text_placeholder')" rows="4" class="form-control" required>{{ old('text') }}</textarea>
	</div>
	@if($errors->has('text'))
	    <span class="help-block">
	        <strong>{{ $errors->first('text') }}</strong>
	    </span>
	@endif
	<div class="form-group">
		<input type="submit" class="btn btn-success" value="@lang('forum/components/create_discussion_form.conclude')">
	</div>
	{{ csrf_field() }}
</form>
