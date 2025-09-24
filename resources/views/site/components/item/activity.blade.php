<div class="item-activity">
    @include('site.components.item.user_picture', [
        'user' => $item->user,
        'size' => '34x34'
    ])
    <p class="item-activity-date descriptive">{{ $item->created_at->diffForHumans() }}</p>
    <p class="item-activity-description">
        <a href="{{ route('user.index', $item->user->slug) }}">{{ $item->user->name }}</a> {{ $text }}
    </p>
</div>