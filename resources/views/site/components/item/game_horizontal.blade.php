<div class="item-game-horizontal">
	<a class="item-game-link" href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
		<div class="item-game-image">
			<img src="{{ $game->getCover($coverSize ?? '78x90') }}">
		</div>
		<div class="item-game-data">
			<div class="item-game-name @if(strlen($game->name) > 37) name-too-long @endif">
				{{ str_limit($game->name, $nameLimit ?? 9999) }}
			</div>
			<div class="item-game-data-bottom">
			    <span class="item-game-release">
				    @if(!$game->isUndated())
					    @if(isset($isExtensiveRelease) and $isExtensiveRelease)
		                    {{ $game->extensiveDate() }}
				        @else
				            {{ $game->release->year }}
				        @endif
				    @else
                        @lang('components/item/game.no_date')
                    @endif
                </span>
                @if(isset($withPlatforms) and $withPlatforms)
				    <ul class="item-game-platforms">
					    @foreach($game->platforms()->take(10)->get() as $platform)
						    <li>@include('site.components.item.platform')</li>
					    @endforeach
					    @if($game->platforms->count() > 10)
						    <li title="@lang('components/item/game.more') {{ ($game->platforms->count() - 10) }} {{ str_plural(trans('components/item/game.platform'), $game->platforms->count() - 10) }}">...<li>
					    @endif
				    </ul>
				@endif
			</div>
		</div>
	</a>
	<div class="item-game-score">
		@if($game->score)
			<a href="{{ route('game.index', ['gameSlug' => $game->slug]) }}">
				@component('site.components.item.score', [
					'score' => $game->score
				])
				@endcomponent
			</a>
		@elseif($game->isAvailable())
			<a class="add-score dialog" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}" title="@lang('components/item/game.add_score')">
				<span class="oi oi-plus"></span>
			</a>
		@elseif(!$game->isUndated())
		    <span class="badge badge-big badge-primary">
			    {{ $game->countdownByDays() }} {{ str_plural(trans('components/item/game.day'), $game->countdownByDays()) }}
		    </span>
	    @endif
	</div>
</div>