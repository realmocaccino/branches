<div class="social-group">
	<div class="social-group-buttons">
		@component('site.components.social.google')
		@endcomponent
	</div>
	@component('site.components.strike', [
		'text' => trans('components/social/login.or')
	])
	@endcomponent
</div>