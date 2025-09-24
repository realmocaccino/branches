<form method="post" action="{{ route('contact.send', [$routeParameter]) }}" class="form-contact">
	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    	<label for="form-name">@lang('components/form/contact.name'):</label>
		<input id="form-name" name="name" type="text" value="{{ old('name', optional($user)->name) }}" class="form-control" required>
		@if($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    	<label for="form-email">@lang('components/form/contact.email'):</label>
		<input id="form-email" name="email" type="email" value="{{ old('email', optional($user)->email) }}" class="form-control" required>
		@if($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
    	<label for="form-message">@lang('components/form/contact.message'):</label>
		<textarea id="form-message" name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
		@if($errors->has('message'))
            <span class="help-block">
                <strong>{{ $errors->first('message') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group" id="form-register-fax">
		<input name="fax" type="text" autocomplete="off">
	</div>
	<button type="submit" class="btn btn-site">@lang('components/form/contact.send')</button>
	{!! csrf_field() !!}
</form>