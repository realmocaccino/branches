@extends('site.layouts.internal.index')

@section('internal_content')
	
	@if($user->picture)
	    <img src="{{ $user->getpicture('180x') }}" width="180">
	    <a href="{{ route('account.picture.delete') }}" class="btn btn-sm btn-outline-danger">@lang('account/picture/index.delete')</a>
	    <hr>
	    <h3><strong>@lang('account/picture/index.change')</strong></h3>
	@endif
	<form id="form-account-picture" method="post" action="{{ route('account.picture.upload') }}" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('picture') ? ' has-error' : '' }}">
		    <input id="form-account-picture-file" name="picture" type="file" accept="image/*" required="required" placeholder="@lang('account/picture/index.label')">
		    @if($errors->has('picture'))
	            <span class="help-block">
	                <strong>{{ $errors->first('picture') }}</strong>
	            </span>
	        @endif
	    </div>
	    <button type="submit" class="btn btn-primary">@lang('account/picture/index.send')</button>
		{!! csrf_field() !!}
	</form>
    
@endsection