<form id="form-account-edit" method="post" action="{{ route('account.edit.save') }}">
	<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    	<label for="form-account-edit-name">@lang('components/form/account/edit/index.name'):</label>
		<input id="form-account-edit-name" name="name" type="text" value="{{ old('name', $user->name) }}" class="form-control" required>
		@if($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
    	<label for="form-account-edit-slug">@lang('components/form/account/edit/index.username'):</label>
		<input id="form-account-edit-slug" name="slug" type="text" value="{{ old('slug', $user->slug) }}" class="form-control" required>
		@if($errors->has('slug'))
            <span class="help-block">
                <strong>{{ $errors->first('slug') }}<strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
    	<label for="form-account-edit-bio">@lang('components/form/account/edit/index.bio'):</label>
		<textarea id="form-account-edit-bio" name="bio" class="form-control">{{ old('bio', $user->bio) }}</textarea>
		@if($errors->has('bio'))
            <span class="help-block">
                <strong>{{ $errors->first('bio') }}<strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('platform') ? ' has-error' : '' }}">
    	<label for="form-account-edit-platform">@lang('components/form/account/edit/index.favorite_platform'):</label>
		<select id="form-account-edit-platform" name="platform" class="form-control">
			<option value="">@lang('components/form/account/edit/index.favorite_platform_placeholder')</option>
			@foreach($platforms as $platform)
				<option value="{{ $platform->id }}" @if(old('platform', $user->platform_id) == $platform->id) selected @endif>{{ $platform->name }}</option>
			@endforeach
		</select>
		@if($errors->has('platform'))
            <span class="help-block">
                <strong>{{ $errors->first('platform') }}<strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
    	<label for="form-account-edit-language">@lang('components/form/account/edit/index.language'):</label>
		<select id="form-account-edit-language" name="language" class="form-control">
			<option value="pt" @if(old('language', $user->language) == 'pt') selected @endif>Português</option>
			<option value="en" @if(old('language', $user->language) == 'en') selected @endif>English</option>
		</select>
		@if($errors->has('language'))
            <span class="help-block">
                <strong>{{ $errors->first('language') }}<strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('mode') ? ' has-error' : '' }}">
    	<label for="form-account-edit-mode">@lang('components/form/account/edit/index.mode'):</label>
		<select id="form-account-edit-mode" name="mode" class="form-control">
			<option value="dark" @if(old('mode', $user->mode) == 'dark') selected @endif>@lang('components/form/account/edit/index.mode_dark')</option>
			<option value="light" @if(old('mode', $user->mode) == 'light') selected @endif>@lang('components/form/account/edit/index.mode_light')</option>
		</select>
		@if($errors->has('mode'))
            <span class="help-block">
                <strong>{{ $errors->first('mode') }}<strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    	<label for="form-account-edit-password">@lang('components/form/account/edit/index.password'):</label>
		<input id="form-account-edit-password" name="password" type="password" value="" class="form-control">
		@if($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group{{ $errors->has('newsletter') ? ' has-error' : '' }}">
		<input id="form-account-newsletter" name="newsletter" type="checkbox" value="1" @if(old('newsletter', $user->newsletter)) checked="checked" @endif>
		<label id="form-account-newsletter-label" for="form-account-newsletter" class="descriptive-form">@lang('components/form/account/edit/index.newsletter') {{ $settings->name }}.</label>
		@if($errors->has('newsletter'))
            <span class="help-block">
                <strong>{{ $errors->first('newsletter') }}</strong>
            </span>
        @endif
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary">@lang('components/form/account/edit/index.update')</button>
	</div>
	{!! csrf_field() !!}
</form>