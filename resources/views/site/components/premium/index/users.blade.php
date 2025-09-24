<div id="premium-users">
    <h2>@lang('premium/index.premium_users')</h2>
    <ul>
        @foreach($premiumUsers as $user)
            <li>
                @component('site.components.item.user_picture', [
                    'user' => $user,
                    'size' => '150x150'
                ])
                @endcomponent
            </li>
        @endforeach
    </ul>
</div>