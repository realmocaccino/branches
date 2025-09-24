@extends('site.layouts.internal.index')

@section('internal_content')

	<form id="form-add" method="post" action="{{ route('request.game.index') }}" enctype="multipart/form-data">
		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			<label for="form-add-name">@lang('add/game/index.name_label'):</label>
			<input id="form-add-name" name="name" type="text" value="{{ old('name', ucwords(request()->get('name'))) }}" class="form-control" placeholder="@lang('add/game/index.name_placeholder')" required>
			@if($errors->has('name'))
		        <span class="help-block">
		            <strong>{{ $errors->first('name') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
			<label for="form-add-alias">@lang('add/game/index.alternative_name_label'):</label>
			<input id="form-add-alias" name="alias" type="text" value="{{ old('alias') }}" class="form-control" placeholder="@lang('add/game/index.alternative_name_placeholder')">
			@if($errors->has('alias'))
		        <span class="help-block">
		            <strong>{{ $errors->first('alias') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
			<label for="form-add-description">@lang('add/game/index.description_label'):</label>
			<textarea id="form-add-description" name="description" rows="4" class="form-control" placeholder="@lang('add/game/index.description_placeholder')">{{ old('description') }}</textarea>
			@if($errors->has('description'))
		        <span class="help-block">
		            <strong>{{ $errors->first('description') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('release') ? ' has-error' : '' }}">
			<label for="form-add-release">@lang('add/game/index.release_date_label'):</label>
			<input id="form-add-release" name="release" type="text" value="{{ old('release') }}" class="form-control" placeholder="@lang('add/game/index.release_date_placeholder')">
			@if($errors->has('release'))
		        <span class="help-block">
		            <strong>{{ $errors->first('release') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group">
			<input id="form-add-isEarlyAccess" name="isEarlyAccess" type="checkbox" value="1" @if(old('isEarlyAccess')) checked @endif>
			<label for="form-add-isEarlyAccess">@lang('add/game/index.early_access_label')</label>
		</div>
		<div class="form-group{{ $errors->has('trailer') ? ' has-error' : '' }}">
			<label for="form-add-trailer">@lang('add/game/index.trailer_label'):</label>
			<input id="form-add-trailer" name="trailer" type="text" value="{{ old('trailer') }}" class="form-control" placeholder="@lang('add/game/index.trailer_placeholder')">
			@if($errors->has('trailer'))
		        <span class="help-block">
		            <strong>{{ $errors->first('trailer') }}</strong>
		        </span>
		    @endif
		</div>
		@if($platforms->count())
			<div class="form-group{{ $errors->has('platforms') ? ' has-error' : '' }}">
				<label for="form-add-platforms">@lang('add/game/index.platforms_label'):</label>
				<select multiple id="form-add-platforms" name="platforms[]" class="form-control" required>
					<option value="" disabled>@lang('add/game/index.platforms_placeholder')</option>
					@foreach($platforms as $platform)
						<option value="{{ $platform->id }}" @if(old('platforms') and in_array($platform->id, old('platforms'))) selected @endif>{{ $platform->name }}</option>
					@endforeach
				</select>
				@if($errors->has('platforms'))
				    <span class="help-block">
				        <strong>{{ $errors->first('platforms') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($genres->count())
			<div class="form-group{{ $errors->has('genres') ? ' has-error' : '' }}">
				<label for="form-add-genres">@lang('add/game/index.genres_label'):</label>
				<select multiple id="form-add-genres" name="genres[]" class="form-control" required>
					<option value="" disabled>@lang('add/game/index.genres_placeholder')</option>
					@foreach($genres as $genre)
						<option value="{{ $genre->id }}" @if(old('genres') and in_array($genre->id, old('genres'))) selected @endif>{{ $genre->name }}</option>
					@endforeach
				</select>
				@if($errors->has('genres'))
				    <span class="help-block">
				        <strong>{{ $errors->first('genres') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($characteristics->count())
			<div class="form-group{{ $errors->has('characteristics') ? ' has-error' : '' }}">
				<label for="form-add-characteristics">@lang('add/game/index.characteristics_label'):</label>
				<select multiple id="form-add-characteristics" name="characteristics[]" class="form-control">
					<option value="" disabled>@lang('add/game/index.characteristics_placeholder')</option>
					@foreach($characteristics as $characteristic)
						<option value="{{ $characteristic->id }}" @if(old('characteristics') and in_array($characteristic->id, old('characteristics'))) selected @endif>{{ $characteristic->name }}</option>
					@endforeach
				</select>
				@if($errors->has('characteristics'))
				    <span class="help-block">
				        <strong>{{ $errors->first('characteristics') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($themes->count())
			<div class="form-group{{ $errors->has('themes') ? ' has-error' : '' }}">
				<label for="form-add-themes">@lang('add/game/index.themes_label'):</label>
				<select multiple id="form-add-themes" name="themes[]" class="form-control">
					<option value="" disabled>@lang('add/game/index.themes_placeholder')</option>
					@foreach($themes as $theme)
						<option value="{{ $theme->id }}" @if(old('themes') and in_array($theme->id, old('themes'))) selected @endif>{{ $theme->name }}</option>
					@endforeach
				</select>
				@if($errors->has('themes'))
				    <span class="help-block">
				        <strong>{{ $errors->first('themes') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($developers->count())
			<div class="form-group{{ $errors->has('developers') ? ' has-error' : '' }}">
				<label for="form-add-developers">@lang('add/game/index.developers_label'):</label>
				<select multiple id="form-add-developers" name="developers[]" class="form-control">
					<option value="" disabled>@lang('add/game/index.developers_placeholder')</option>
					@foreach($developers as $developer)
						<option value="{{ $developer->id }}" @if(old('developers') and in_array($developer->id, old('developers'))) selected @endif>{{ $developer->name }}</option>
					@endforeach
				</select>
				@if($errors->has('developers'))
				    <span class="help-block">
				        <strong>{{ $errors->first('developers') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		<a id="form-add-no-developer-found-button">@lang('add/game/index.no_developer_found')</a>
		<div id="form-add-create-developer-publisher-section" class="form-group">
			<label for="form-add-create-developer">@lang('add/game/index.create_developer_label'):</label>
			<input id="form-add-create-developer" name="new_developer_name" type="text" value="{{ old('new_developer_name', ucwords(request()->get('new_developer_name'))) }}" class="form-control" placeholder="@lang('add/game/index.create_developer_placeholder')">
			<input id="form-create-publisher-with-same-name" name="create_publisher_with_same_name" type="checkbox" value="1" @if(old('create_publisher_with_same_name')) checked @endif> <label for="form-create-publisher-with-same-name">@lang('add/game/index.create_publisher_with_same_name_label')</label>
		</div>
		@if($publishers->count())
			<div class="form-group{{ $errors->has('publishers') ? ' has-error' : '' }}">
				<label for="form-add-publishers">@lang('add/game/index.publishers_label'):</label>
				<select multiple id="form-add-publishers" name="publishers[]" class="form-control">
					<option value="" disabled>@lang('add/game/index.publishers_placeholder')</option>
					@foreach($publishers as $publisher)
						<option value="{{ $publisher->id }}" @if(old('publishers') and in_array($publisher->id, old('publishers'))) selected @endif>{{ $publisher->name }}</option>
					@endforeach
				</select>
				@if($errors->has('publishers'))
				    <span class="help-block">
				        <strong>{{ $errors->first('publishers') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($franchises->count())
			<div class="form-group{{ $errors->has('franchises') ? ' has-error' : '' }}">
				<label for="form-add-franchises">@lang('add/game/index.franchises_label'):</label>
				<select multiple id="form-add-franchises" name="franchises[]" class="form-control">
					<option value="" disabled>@lang('add/game/index.franchises_placeholder')</option>
					@foreach($franchises as $franchise)
						<option value="{{ $franchise->id }}" @if(old('franchises') and in_array($franchise->id, old('franchises'))) selected @endif>{{ $franchise->name }}</option>
					@endforeach
				</select>
				@if($errors->has('franchises'))
				    <span class="help-block">
				        <strong>{{ $errors->first('franchises') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($modes->count())
			<div class="form-group{{ $errors->has('modes') ? ' has-error' : '' }}" id="form-add-modes">
				<label for="form-add-modes-{{ $modes[0]->slug }}">@lang('add/game/index.modes_label'):</label>
				@foreach($modes as $mode)
					<div class="form-add-modes-group">
						<input id="form-add-modes-{{ $mode->slug }}" name="modes[]" type="checkbox" value="{{ $mode->id }}" @if(old('modes') and in_array($mode->id, old('modes'))) checked @endif> <label for="form-add-modes-{{ $mode->slug }}">{{ $mode->name }}</label>
					</div>
				@endforeach
				@if($errors->has('modes'))
				    <span class="help-block">
				        <strong>{{ $errors->first('modes') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		<div class="form-group{{ $errors->has('campaign') ? ' has-error' : '' }}">
			<label for="form-add-campaign-yes">@lang('add/game/index.campaign_label')</label>
			<input id="form-add-campaign-yes" name="campaign" type="radio" value="1" required @if(old('campaign') == '1') checked @endif> <label for="form-add-campaign-yes">@lang('add/game/index.campaign_yes')</label>
			<input id="form-add-campaign-no" name="campaign" type="radio" value="0" required @if(old('campaign') == '0') checked @endif> <label for="form-add-campaign-no">@lang('add/game/index.campaign_no')</label>
			@if($errors->has('campaign'))
		        <span class="help-block">
		            <strong>{{ $errors->first('campaign') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('cover') ? ' has-error' : '' }}">
			<label for="form-add-cover">@lang('add/game/index.cover_label'):</label>
			<input id="form-add-cover" name="cover" type="file" placeholder="Envie a capa do jogo">
			<img id="form-add-cover-preview">
			@if($errors->has('cover'))
		        <span class="help-block">
		            <strong>{{ $errors->first('cover') }}</strong>
		        </span>
		    @endif
			<div id="form-add-cover-errorMessage" class="alert alert-danger"></div>
		    <div id="form-add-cover-description" class="descriptive">@lang('add/game/index.cover_ideal_size'): 350px @lang('add/game/index.cover_width') x 450px @lang('add/game/index.cover_height')</div>
		</div>
		<button type="submit" class="btn btn-site">@lang('add/game/index.submit')</button>
		{!! csrf_field() !!}
	</form>

@endsection
