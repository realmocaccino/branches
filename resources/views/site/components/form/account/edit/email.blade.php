<form id="form-account-edit" method="post" action="{{ route('account.edit.email') }}">
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    	<label for="form-account-edit-email">@lang('components/form/account/edit/email.new_email'):</label>
		<input id="form-account-edit-email" name="email" type="email" value="{{ old('email') }}" class="form-control" required>
		@if($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('email_confirmation') ? ' has-error' : '' }}">
    	<label for="form-account-edit-email_confirmation">@lang('components/form/account/edit/email.confirm_email'):</label>
		<input id="form-account-edit-email_confirmation" name="email_confirmation" type="email" value="{{ old('email_confirmation') }}" class="form-control" required>
		@if($errors->has('email_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('email_confirmation') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">@lang('components/form/account/edit/email.update')</button>
	</div>
	{!! csrf_field() !!}
</form>
