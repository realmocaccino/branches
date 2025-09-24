<div id="premium-checkout-plan">
    <img id="premium-checkout-premiumIcon" src="{{ asset('img/premium.png') }}">
    <h2>{{ $plan->name }}</h2>
    <p class="descriptive">@lang('premium/checkout.valid_until'): {{ $plan->validity->format('d/m/Y') }}</p>
</div>