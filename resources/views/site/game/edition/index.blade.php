@extends('site.layouts.internal.index')

@section('internal_content')

	<form id="form-game-edit" method="post" action="{{ route('game.edition.request', $game->slug) }}" enctype="multipart/form-data">
		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			<label for="form-game-edit-name">@lang('game/edition/index.name_label'):</label>
			<input id="form-game-edit-name" name="name" type="text" value="{{ old('name', $game->name) }}" class="form-control" placeholder="@lang('game/edition/index.name_placeholder')" required>
			@if($errors->has('name'))
		        <span class="help-block">
		            <strong>{{ $errors->first('name') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('alias') ? ' has-error' : '' }}">
			<label for="form-game-edit-alias">@lang('game/edition/index.alternative_name_label'):</label>
			<input id="form-game-edit-alias" name="alias" type="text" value="{{ old('alias', $game->alias) }}" class="form-control" placeholder="@lang('game/edition/index.alternative_name_placeholder')">
			@if($errors->has('alias'))
		        <span class="help-block">
		            <strong>{{ $errors->first('alias') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
			<label for="form-game-edit-description">@lang('game/edition/index.description_label'):</label>
			<textarea id="form-game-edit-description" name="description" rows="4" class="form-control" placeholder="@lang('game/edition/index.description_placeholder')">{{ old('description', $game->description) }}</textarea>
			@if($errors->has('description'))
		        <span class="help-block">
		            <strong>{{ $errors->first('description') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group{{ $errors->has('release') ? ' has-error' : '' }}">
			<label for="form-game-edit-release">@lang('game/edition/index.release_date_label'):</label>
			<input id="form-game-edit-release" name="release" type="text" value="{{ old('release', optional($game->release)->format('d/m/Y')) }}" class="form-control" placeholder="@lang('game/edition/index.release_date_placeholder')">
			@if($errors->has('release'))
		        <span class="help-block">
		            <strong>{{ $errors->first('release') }}</strong>
		        </span>
		    @endif
		</div>
		<div class="form-group">
			<input id="form-game-edit-isEarlyAccess" name="isEarlyAccess" type="checkbox" value="1" @if(old('isEarlyAccess', $game->is_early_access)) checked @endif>
			<label for="form-game-edit-isEarlyAccess">@lang('game/edition/index.early_access_label')</label>
		</div>
		<div class="form-group{{ $errors->has('trailer') ? ' has-error' : '' }}">
			<label for="form-game-edit-trailer">@lang('game/edition/index.trailer_label'):</label>
			<input id="form-game-edit-trailer" name="trailer" type="text" value="{{ old('trailer', $game->trailer) }}" class="form-control" placeholder="@lang('game/edition/index.trailer_placeholder')">
			@if($errors->has('trailer'))
		        <span class="help-block">
		            <strong>{{ $errors->first('trailer') }}</strong>
		        </span>
		    @endif
		</div>
		@if($platforms->count())
			<div class="form-group{{ $errors->has('platforms') ? ' has-error' : '' }}">
				<label for="form-game-edit-platforms">@lang('game/edition/index.platforms_label'):</label>
				<select multiple id="form-game-edit-platforms" name="platforms[]" class="form-control" required>
					<option value="" disabled>@lang('game/edition/index.platforms_placeholder')</option>
					@foreach($platforms as $platform)
						<option value="{{ $platform->id }}" @if(in_array($platform->id, old('platforms', $game->platforms->pluck('id')->all()))) selected @endif>{{ $platform->name }}</option>
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
				<label for="form-game-edit-genres">@lang('game/edition/index.genres_label'):</label>
				<select multiple id="form-game-edit-genres" name="genres[]" class="form-control" required>
					<option value="" disabled>@lang('game/edition/index.genres_placeholder')</option>
					@foreach($genres as $genre)
						<option value="{{ $genre->id }}" @if(in_array($genre->id, old('genres', $game->genres->pluck('id')->all()))) selected @endif>{{ $genre->name }}</option>
					@endforeach
				</select>
				@if($errors->has('genres'))
				    <span class="help-block">
				        <strong>{{ $errors->first('genres') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($modes->count())
			<div class="form-group{{ $errors->has('modes') ? ' has-error' : '' }}" id="form-game-edit-modes">
				<label for="form-game-edit-modes-{{ $modes[0]->slug }}">@lang('game/edition/index.modes_label'):</label>
				@foreach($modes as $mode)
					<div class="form-game-edit-modes-group">
						<input id="form-game-edit-modes-{{ $mode->slug }}" name="modes[]" type="checkbox" value="{{ $mode->id }}" @if(in_array($mode->id, old('modes', $game->modes->pluck('id')->all()))) checked @endif> <label for="form-game-edit-modes-{{ $mode->slug }}">{{ $mode->name }}</label>
					</div>
				@endforeach
				@if($errors->has('modes'))
				    <span class="help-block">
				        <strong>{{ $errors->first('modes') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($characteristics->count())
			<div class="form-group{{ $errors->has('characteristics') ? ' has-error' : '' }}">
				<label for="form-game-edit-characteristics">@lang('game/edition/index.characteristics_label'):</label>
				<select multiple id="form-game-edit-characteristics" name="characteristics[]" class="form-control">
					<option value="" disabled>@lang('game/edition/index.characteristics_placeholder')</option>
					@foreach($characteristics as $characteristic)
						<option value="{{ $characteristic->id }}" @if(in_array($characteristic->id, old('characteristics', $game->characteristics->pluck('id')->all()))) selected @endif>{{ $characteristic->name }}</option>
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
				<label for="form-game-edit-themes">@lang('game/edition/index.themes_label'):</label>
				<select multiple id="form-game-edit-themes" name="themes[]" class="form-control">
					<option value="" disabled>@lang('game/edition/index.themes_placeholder')</option>
					@foreach($themes as $theme)
						<option value="{{ $theme->id }}" @if(in_array($theme->id, old('themes', $game->themes->pluck('id')->all()))) selected @endif>{{ $theme->name }}</option>
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
				<label for="form-game-edit-developers">@lang('game/edition/index.developers_label'):</label>
				<select multiple id="form-game-edit-developers" name="developers[]" class="form-control">
					<option value="" disabled>@lang('game/edition/index.developers_placeholder')</option>
					@foreach($developers as $developer)
						<option value="{{ $developer->id }}" @if(in_array($developer->id, old('developers', $game->developers->pluck('id')->all()))) selected @endif>{{ $developer->name }}</option>
					@endforeach
				</select>
				@if($errors->has('developers'))
				    <span class="help-block">
				        <strong>{{ $errors->first('developers') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($publishers->count())
			<div class="form-group{{ $errors->has('publishers') ? ' has-error' : '' }}">
				<label for="form-game-edit-publishers">@lang('game/edition/index.publishers_label'):</label>
				<select multiple id="form-game-edit-publishers" name="publishers[]" class="form-control">
					<option value="" disabled>@lang('game/edition/index.publishers_placeholder')</option>
					@foreach($publishers as $publisher)
						<option value="{{ $publisher->id }}" @if(in_array($publisher->id, old('publishers', $game->publishers->pluck('id')->all()))) selected @endif>{{ $publisher->name }}</option>
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
			<div class="form-group{{ $errors->has('franchises') ? ' has-error' : '' }}" id="form-game-edit-modes">
				<label for="form-game-edit-franchises">@lang('game/edition/index.franchises_label'):</label>
				<select multiple id="form-game-edit-franchises" name="franchises[]" class="form-control">
					<option value="" disabled>@lang('game/edition/index.franchises_placeholder')</option>
					@foreach($franchises as $franchise)
						<option value="{{ $franchise->id }}" @if(in_array($franchise->id, old('franchises', $game->franchises->pluck('id')->all()))) selected @endif>{{ $franchise->name }}</option>
					@endforeach
				</select>
				@if($errors->has('franchises'))
				    <span class="help-block">
				        <strong>{{ $errors->first('franchises') }}</strong>
				    </span>
				@endif
			</div>
		@endif
		@if($canEdit)
		    <div class="form-group{{ $errors->has('cover') ? ' has-error' : '' }}">
			    <label for="form-add-cover">@lang('game/edition/index.cover_label'):</label>
			    <input id="form-add-cover" name="cover" type="file" placeholder="Envie a capa do jogo">
			    @if($errors->has('cover'))
		            <span class="help-block">
		                <strong>{{ $errors->first('cover') }}</strong>
		            </span>
		        @endif
		        <div id="form-add-cover-description" class="descriptive">@lang('game/edition/index.cover_ideal_size'): 350px @lang('game/edition/index.cover_width') x 450px @lang('game/edition/index.cover_height')</div>
		    </div>
		@endif
		<input type="hidden" name="id" value="{{ $game->id }}">
		<button type="submit" class="btn btn-primary">{{ $canEdit ? trans('game/edition/index.update') : trans('game/edition/index.submit') }}</button>
		{!! csrf_field() !!}
	</form>

@endsection
