<div id="mobile-side-site">
	<div id="mobile-side-site-header"></div>
	<div id="mobile-side-site-body">
		<div id="mobile-side-site-social">
			<p>@lang('layouts/main/sides.join_our_discord_server')</p>
			<div id="mobile-side-site-social-icons">
				@component('site.components.social.discord')
				@endcomponent
			</div>
		</div>
		<hr>
		<ul id="mobile-side-site-menu">
			{!! Menu::show('mobile') !!}
		</ul>
	</div>
</div>
<div id="mobile-side-user">
	@include('site.ajax.layouts.main.side_user', [
		'user' => Auth::guard('site')->user()
	])
</div>