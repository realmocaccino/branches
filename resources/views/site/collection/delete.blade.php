@extends('site.layouts.internal.index', [
    'smaller' => true
])

@section('internal_content')

    <div class="row" id="collection-deletePage">
	    <div class="col-12">
	        <p id="internal-descriptive">@lang('collection/delete.are_you_sure') <strong>{{ $collection->name }}</strong>?</p>
	        <form id="form-account-delete" method="post" action="{{ route('collection.delete', $collection->slug) }}">
	            <div class="form-group">
	                <a href="{{ route('collection.index', [$collection->user->slug, $collection->slug]) }}" class="btn btn-info">@lang('collection/delete.cancel')</a>
		            <button type="submit" class="btn btn-danger">@lang('collection/delete.confirm')</button>
	            </div>
	            {!! csrf_field() !!}
            </form>
        </div>
	</div>

@endsection