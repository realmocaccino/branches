<form method="post" action="{{ route('password.redefinePassword') }}" class="form-contact">
	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    	<label for="form-password">@lang('components/form/redefine_password.password'):</label>
		<input id="form-password" name="password" type="password" value="{{ old('password') }}" class="form-control" required>
		@if($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    	<label for="form-password_confirmation">@lang('components/form/redefine_password.password_confirmation'):</label>
		<input id="form-password_confirmation" name="password_confirmation" type="password" value="{{ old('password_confirmation') }}" class="form-control" required>
		@if($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
        @endif
	</div>
	<input type="hidden" name="token" value="{{ $token }}">
	<div class="form-group">
		<button type="submit" class="btn btn-primary">@lang('components/form/redefine_password.send')</button>
	</div>
	{!! csrf_field() !!}
</form>
