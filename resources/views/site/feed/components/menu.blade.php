<ul>
    @auth('site')
        <li>
            <a class="btn @if($currentRouteName == 'feed.index') btn-primary @else btn-outline-primary @endif" href="{{ route('feed.index', $filterBy) }}">
                @lang('feed/index.filter_all')
            </a>
        </li>
        <li>
            <a class="btn @if($currentRouteName == 'feed.following') btn-primary @else btn-outline-primary @endif" href="{{ route('feed.following', $filterBy) }}">
                @lang('feed/index.filter_following')
            </a>
        </li>
        <li>
            <a class="btn @if($currentRouteName == 'feed.me') btn-primary @else btn-outline-primary @endif" href="{{ route('feed.me', $filterBy) }}">
                @lang('feed/index.filter_me')
            </a>
        </li>
    @endauth
    <li>
        <a class="btn @if(!$filterBy) btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName) }}">
            @lang('feed/index.filter_everything')
        </a>
    </li>
    <li>
        <a class="btn @if($filterBy === 'ratings') btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName, 'ratings') }}">
            @lang('feed/index.filter_ratings')
        </a>
    </li>
    <li>
        <a class="btn @if($filterBy === 'reviews') btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName, 'reviews') }}">
            @lang('feed/index.filter_reviews')
        </a>
    </li>
    <li>
        <a class="btn @if($filterBy === 'collections') btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName, 'collections') }}">
            @lang('feed/index.filter_collections')
        </a>
    </li>
    <li>
        <a class="btn @if($filterBy === 'contributions') btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName, 'contributions') }}">
            @lang('feed/index.filter_contributions')
        </a>
    </li>
    <li>
        <a class="btn @if($filterBy === 'reviewFeedbacks') btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName, 'reviewFeedbacks') }}">
            @lang('feed/index.filter_likes')
        </a>
    </li>
    <li>
        <a class="btn @if($filterBy === 'follows') btn-secondary @else btn-site-light @endif" href="{{ route($currentRouteName, 'follows') }}">
            @lang('feed/index.filter_follows')
        </a>
    </li>
</ul>