<div id="premium-checkout">
    <div id="premium-checkout-brand">
		@include('site.components.brand', [
            'image' => 'dark'
        ])
	</div>
	<div id="premium-checkout-user">
	    @component('site.components.item.user_picture', [
			'user' => auth()->user(),
			'size' => '34x34'
		])
		@endcomponent
    </div>
	@include('site.components.premium.checkout.plan')
    @include('site.components.premium.checkout.form')
    <hr>
    <a id="premium-checkout-supportLink" href="{{ route('contact.index', ['contactPage' => 'support']) }}">@lang('components/form/login.support')</a>
</div>
<script>
    premium.createCardComponent();
</script>