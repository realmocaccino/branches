<form method="post" action="{{ route('login.authenticate') }}" data-ajax-url="{{ route('login.ajax.authenticate') }}" id="form-login" class="form-contact">
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    	<label for="form-login-email">@lang('components/form/login.email')</label>
		<input id="form-login-email" name="email" type="email" value="{{ old('email') }}" class="form-control" required>
		@if($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    	<label for="form-login-password">@lang('components/form/login.password')</label>
		<input id="form-login-password" name="password" type="password" value="" class="form-control" required>
		@if($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group" id="form-login-last-group">
		<button type="submit" id="form-login-submitButton" class="btn btn-block btn-primary">@lang('components/form/login.login')</button>
		<a href="{{ route('password.forgotPassword') }}" class="btn btn-link">@lang('components/form/login.forgot_password')</a> &bullet;
		<a href="{{ route('contact.index', ['contactPage' => 'support']) }}" class="btn btn-link">@lang('components/form/login.support')</a>
	</div>
	{!! csrf_field() !!}
</form>