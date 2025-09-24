<section id="game-buttons">
	<div id="game-buttons-main">
		@if($game->isAvailable())
			@include('site.game.components.rateButton')
		@else
			@if(isset($askedToWarn) and $askedToWarn)
				<a id="game-warnMe-cancelButton" class="btn btn-primary active" href="{{ route('game.cancelWarnMe', $game->slug) }}"><em class="fa fa-check"></em> @lang('game/components/buttons.cancel_reminder')</a>
			@else
				<a id="game-warnMe-button" class="btn btn-primary" href="{{ route('game.warnMe', $game->slug) }}">@lang('game/components/buttons.remind_me')</a>
			@endif
		@endif
	</div>
	<div id="game-buttons-collections">
		<div id="game-buttons-collections-plus" class="btn btn-info" data-dropdown="game-buttons-collections-tooltip">
			<em class="fa fa-plus"></em>
		</div>
		<div id="game-buttons-collections-tooltip">
    		{!! $buttonsTooltip !!}
		</div>
	</div>
	<!--@if($game->isUndated())
		<a id="game-searchForReleaseDateButton"  class="btn btn-outline-secondary" href="{{ route('game.searchForReleaseDate', $game->slug) }}">@lang('game/components/buttons.search_for_release_date')</a>
	@endif
	<a id="game-editButton" class="btn btn-outline-secondary" href="{{ route('game.edition.index', $game->slug) }}">@lang('game/components/buttons.edit')</a>
	@if($isOfficialUser)
		<a id="game-touchUpButton"  class="btn btn-outline-secondary" href="{{ route('game.touchUp', $game->slug) }}">@lang('game/components/buttons.touch_up')</a>
    @endif-->
</section>