<div class="row">
	<div class="col-lg-3 col-12" id="footer-left">
	    <div id="footer-brand">
			@include('site.components.brand')
	    </div>
		<div id="footer-social">
		    <p>@lang('layouts/main/footer.join_our_discord_server')</p>
			<div id="footer-social-icons">
				@component('site.components.social.discord', [
                	'size' => 'small'
				])
				@endcomponent
			</div>
		</div>
		<div id="footer-rights">&copy; {{ date('Y') }} notadogame.com</div>
	</div>
	<div class="col-lg-9 d-none d-lg-block">
		<ul id="footer-menu">
			{!! Menu::show('footer') !!}
		</ul>
	</div>
</div>