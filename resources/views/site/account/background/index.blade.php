@extends('site.layouts.internal.index')

@section('internal_content')
	
	@if($user->background)
	    <img src="{{ $user->getBackground('576x324') }}" width="400">
	    <a href="{{ route('account.background.delete') }}" class="btn btn-sm btn-outline-danger">@lang('account/background/index.delete')</a>
	    <hr>
	    <h3><strong>@lang('account/background/index.change')</strong></h3>
	@endif
	<form id="form-background" method="post" action="{{ route('account.background.upload') }}" enctype="multipart/form-data">
        <div class="form-group{{ $errors->has('background') ? ' has-error' : '' }}">
		    <input id="form-background-file" name="background" type="file" accept="image/*" required="required" placeholder="@lang('account/background/index.label')">
		    @if($errors->has('background'))
	            <span class="help-block">
	                <strong>{{ $errors->first('background') }}</strong>
	            </span>
	        @endif
	        <div id="form-background-description" class="descriptive">@lang('account/background/index.ideal_size'): 1920px @lang('account/background/index.width') x 300px @lang('account/background/index.height')</div>
	    </div>
	    <button type="submit" class="btn btn-primary">@lang('account/background/index.send')</button>
		{!! csrf_field() !!}
	</form>
    
@endsection