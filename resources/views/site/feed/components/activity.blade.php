@switch($activity->entity)
    @case('collection')
        @include('site.components.item.activity', [
            'item' => $activity,
            'text' => trans('components/item/activity.collection_text')
        ])
        @include('site.components.item.collection', [
            'collection' => $activity
        ])
        @break
    @case('contribution')
        @include('site.components.item.activity', [
            'item' => $activity,
            'text' => trans('components/item/activity.contribution_text') . $settings->name
        ])
        @include('site.components.item.game', [
            'game' => $activity->game
        ])
        @break
    @case('rating')
        @include('site.components.item.activity', [
            'item' => $activity,
            'text' => trans('components/item/activity.rating_text')
        ])
        @include('site.components.item.rating', [
            'rating' => $activity
        ])
        @break
    @case('review')
        @include('site.components.item.activity', [
            'item' => $activity,
            'text' => trans('components/item/activity.review_text')
        ])
        @include('site.components.item.review', [
            'review' => $activity,
            'cover' => 'game'
        ])
        @break
    @case('reviewFeedback')
        @include('site.components.item.activity', [
            'item' => $activity,
            'text' => trans('components/item/activity.likedReview_text')
        ])
        @include('site.components.item.review', [
            'review' => $activity->review,
            'cover' => 'game_user'
        ])
        @break
    @case('follow')
        <div class="item-activity">
            @include('site.components.item.user_picture', [
                'user' => $activity->follower,
                'size' => '34x34'
            ])
            <p class="item-activity-date descriptive">{{ $activity->created_at->diffForHumans() }}</p>
            <p class="item-activity-description">
                <a href="{{ route('user.index', $activity->follower->slug) }}">{{ $activity->follower->name }}</a> {{ trans('components/item/activity.follow_text') }}
            </p>
        </div>
        @include('site.components.item.user', [
            'user' => $activity->following
        ])
        @break
    @case('like')
        @if($activity->game)
            @include('site.components.item.activity', [
                'item' => $activity,
                'text' => trans('components/item/activity.like_text')
            ])
            @include('site.components.item.game', [
                'game' => $activity->game
            ])
        @endif
        @break
    @case('want')
        @if($activity->game)
            @include('site.components.item.activity', [
                'item' => $activity,
                'text' => trans('components/item/activity.want_text')
            ])
            @include('site.components.item.game', [
                'game' => $activity->game
            ])
        @endif
        @break
@endswitch