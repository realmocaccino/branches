<div id="login-register">
	<div id="login-register-logo">
		@include('site.components.brand')
	</div>
	<div id="login-register-tabs">
		<ul id="login-register-tabs-buttons">
			<li @if($active == 'login') class="active" @endif>@lang('ajax/login_register.login')</li>
			<li @if($active == 'register') class="active" @endif>@lang('ajax/login_register.register')</li>
		</ul>
		@component('site.components.social.login')@endcomponent
		<ul id="login-register-tabs-contents">
			<li @if($active == 'login') class="active" @endif>
				<span class="login-register-error" id="login-register-error-login"></span>
				@component('site.components.form.login')@endcomponent
			</li>
			<li @if($active == 'register') class="active" @endif>
				<span class="login-register-error" id="login-register-error-register"></span>
				@component('site.components.form.register')@endcomponent
			</li>
		</ul>
	</div>
</div>