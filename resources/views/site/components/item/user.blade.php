<?php $points = $points ?? false; ?>
<div class="item-user">
	<a class="item-user-link" href="{{ route('user.index', ['userSlug' => $user->slug]) }}">
		<div class="item-user-image">
			<img src="{{ $user->getPicture($pictureSize ?? '150x150') }}" alt="@lang('components/item/user.picture_of') {{ $user->name }}">
		</div>
		<div class="item-user-data">
			<p class="item-user-name">{{ str_limit($user->name, 30) }}</p>
			<p class="item-user-slug descriptive">{{ '@' . $user->slug, 30 }}</p>
		</div>
		<div class="item-user-level">
			@component('site.components.item.level', [
				'level' => $user->level
			])
			@endcomponent
		</div>
	</a>
</div>