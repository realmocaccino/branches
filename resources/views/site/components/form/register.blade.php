<form method="post" action="{{ route('register.store') }}" data-ajax-url="{{ route('register.ajax.store') }}" id="form-register" class="form-contact">
	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    	<label for="form-register-name">@lang('components/form/register.name')</label>
		<input id="form-register-name" name="name" type="text" value="{{ old('name', request('name'))  }}" class="form-control" required>
		@if($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    	<label for="form-register-email">@lang('components/form/register.email')</label>
		<input id="form-register-email" name="email" type="email" value="{{ old('email', request('email')) }}" class="form-control" required>
		@if($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
	@if(!request()->ajax())
		<div class="form-group{{ $errors->has('email_confirmation') ? ' has-error' : '' }}">
			<label for="form-register-email_confirmation">@lang('components/form/register.email_confirmation')</label>
			<input id="form-register-email_confirmation" name="email_confirmation" type="email" value="{{ old('email_confirmation') }}" class="form-control" required>
			@if($errors->has('email_confirmation'))
		        <span class="help-block">
		            <strong>{{ $errors->first('email_confirmation') }}</strong>
		        </span>
		    @endif
		</div>
	@endif
	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    	<label for="form-register-password">@lang('components/form/register.password')</label>
		<input id="form-register-password" name="password" type="password" value="" class="form-control" required>
		@if($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group" id="form-register-fax">
		<input name="fax" type="text" autocomplete="off">
	</div>
	<div class="form-group{{ $errors->has('terms') ? ' has-error' : '' }}">
		<input id="form-register-terms" name="terms" type="checkbox" value="1" required @if(!session()->getOldInput() or old('terms')) checked="checked" @endif>
		<label id="form-register-terms-label" for="form-register-terms" class="ordinary-text">@lang('components/form/register.agreement_start') <a href="{{ route('institutional', ['terms']) }}" target="_blank" class="featured">@lang('components/form/register.agreement_terms')</a> @lang('components/form/register.agreement_and') <a href="{{ route('institutional', ['privacy']) }}" target="_blank" class="featured">@lang('components/form/register.agreement_privacy')</a></label>
		@if($errors->has('terms'))
            <span class="help-block">
                <strong>{{ $errors->first('terms') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group">
		<button type="submit" id="form-register-submitButton" class="btn btn-block btn-success">@lang('components/form/register.register')</button>
	</div>
	{!! csrf_field() !!}
</form>