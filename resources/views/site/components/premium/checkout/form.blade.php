<form id="premium-checkout-form">
    <div id="premium-checkout-card"></div>
    <button id="premium-checkout-submit">
        <div id="premium-checkout-spinner" class="hidden"></div>
        <span id="premium-checkout-submit-text">Pagar ({{ $plan->priceInBRL() }})</span>
    </button>
    <p id="premium-checkout-errorMessage" role="alert"></p>
    <input id="premium-checkout-planId" type="hidden" value="{{ $plan->id }}">
    <input id="premium-checkout-key" type="hidden" value="{{ config('services.stripe.key') }}">
</form>