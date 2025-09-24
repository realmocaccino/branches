@extends('site.layouts.internal.index', [
    'smaller' => true
])

@section('internal_content')

    <div class="row" id="collection-editPage">
	    <div class="col-12">
	        <form id="form-account-editCollection" method="post" action="{{ route('collection.edit', $collection->slug) }}">
	            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                	<label for="form-account-editCollection-name">@lang('collection/edit.name'):</label>
		            <input id="form-account-editCollection-name" name="name" type="text" value="{{ old('name', $collection->name) }}" class="form-control" required>
		            @if($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
	            </div>
	            <div class="form-group{{ $errors->has('private') ? ' has-error' : '' }}">
		            <input id="form-account-editCollection-newsletter" name="private" type="checkbox" value="1" @if(old('private', $collection->private)) checked="checked" @endif>
		            <label id="form-account-editCollection-newsletter-label" for="form-account-editCollection-newsletter" class="descriptive-form">@lang('collection/edit.private')</label>
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
        </div>
    </div>

@endsection