<div class="item-answer">
	<div class="item-answer-info">
		@component('site.components.item.user_picture', [
			'user' => $entity->user,
			'size' => '34x34'
		])
		@endcomponent
		<a href="{{ route('user.index', [$entity->user->slug]) }}" title="@lang('forum/components/item_answer.see_user')">{{ $entity->user->name }}</a> em {{ $entity->created_at->format('d/m/Y à\s H:i') }}
	</div>
	@if(Auth::id() == $entity->user->id)
		<a class="item-answer-deleteBtn" href="{{ isset($game) ? route('game.forum.delete' . ($entity->getTable() == 'answers' ? 'Answer' : 'Discussion'), [$game->slug, $entity->id]) : route('forum.delete' . ($entity->getTable() == 'answers' ? 'Answer' : 'Discussion'), [$entity->id]) }}" title="@lang('forum/components/item_answer.delete')">
			<i class="fa fa-trash" alt="@lang('forum/components/item_answer.delete')"></i>
		</a>
	@endif
	<div class="item-answer-text">{{ $entity->text }}</div>
</div>
