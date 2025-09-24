@if(!$user or !$user->isPremium())
    <p><strong>@lang('premium/index.choose_a_plan')</strong></p>
    <div class="premium-buttons">
        @foreach($plans as $plan)
            <a class="premium-button dialog btn btn-dark" href="{{ route('premium.checkout', $plan->id) }}" data-ajax-url="{{ route('premium.ajax.checkout', $plan->id) }}">
                {{ $plan->name }} - {{ $plan->priceInBRL() }}
            </a>
        @endforeach
    </div>
@else
    <div class="premium-alreadyIs">
        <p>@lang('premium/index.already_subscribed')</p>
        <p>Expira em: {{ $user->premiumSubscription()->expires_at->format('d/m/Y \à\s h:m') }}</p>
    </div>
@endif