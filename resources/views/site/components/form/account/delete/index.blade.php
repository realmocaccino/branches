<form id="form-account-delete" method="post" action="{{ route('account.delete.confirm') }}">
	@if($user->password)
		<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
			<label for="form-account-edit-password">@lang('components/form/account/delete/index.password'):</label>
			<input id="form-account-edit-password" name="password" type="password" value="" class="form-control" required>
			@if($errors->has('password'))
		        <span class="help-block">
		            <strong>{{ $errors->first('password') }}</strong>
		        </span>
		    @endif
		</div>
	@endif
	<div class="form-group">
		<button type="submit" class="btn btn-danger">@lang('components/form/account/delete/index.delete')</button>
	</div>
	{!! csrf_field() !!}
</form>