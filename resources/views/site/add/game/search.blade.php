@extends('site.layouts.internal.index')

@section('internal_content')

    <div id="add-game-search">
        <form id="add-game-search-form" method="get" action="{{ route('add.game.choose') }}" enctype="multipart/form-data">
	        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		        <label for="add-game-search-form-name">@lang('add/game/search.name_label'):</label>
		        <input id="add-game-search-form-name" name="name" type="text" value="{{ old('name', ucwords(request()->get('name'))) }}" class="form-control" placeholder="@lang('add/game/search.name_placeholder')" required>
		        @if($errors->has('name'))
	                <span class="help-block">
	                    <strong>{{ $errors->first('name') }}</strong>
	                </span>
	            @endif
	        </div>
	        <button id="add-game-search-button" type="submit" class="btn btn-site">@lang('add/game/search.submit')</button>
			@if(session()->has('alert'))
	        	<a href="{{ @route('add.game.index') }}?name={{ old('name') }}" class="btn btn-link add-game-insert-manually-button">@lang('add/game/search.insert_manually')</a>
			@endif
        </form>
	</div>

@endsection
