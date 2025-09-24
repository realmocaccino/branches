<a class="item-user-picture" href="{{ route('user.index', ['userSlug' => $user->slug]) }}" @if(!isset($noTitle) or !$noTitle) title="{{ $user->name }}" @endif>
    <img class="item-user-picture-image item-user-picture-image-{{ $size ?? '78x90' }}" src="{{ $user->getPicture($size ?? '78x90') }}" alt="@lang('components/item/user_picture.picture_of') {{ $user->name }}">
    @if($user->isPremium())
        <div class="item-user-picture-premium" title="Premium">
            <img src="{{ asset('img/premium.png') }}" alt="Premium">
        </div>
    @endif
</a>