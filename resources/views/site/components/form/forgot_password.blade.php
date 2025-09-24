<form method="post" action="{{ route('password.sendToken') }}" class="form-contact">
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    	<label for="form-email">@lang('components/form/forgot_password.email'):</label>
		<input id="form-email" name="email" type="text" value="{{ old('email') }}" class="form-control" required>
		@if($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">@lang('components/form/forgot_password.send')</button>
	</div>
	{!! csrf_field() !!}
</form>
