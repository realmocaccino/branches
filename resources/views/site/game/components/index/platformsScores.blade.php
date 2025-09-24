@if($game->ratings->count())
    <section id="game-index-platformsScores">
	    @component('site.components.title', [
		    'title' => trans('game/components/index/platformsScores.scores_by_platform')
	    ])
	    @endcomponent
	    <table id="game-index-platformsScores-table" class="table table-hover">
		    <tr>
			    <th width="44%">@lang('game/components/index/platformsScores.platform')</th>
			    <th width="13%" class="text-center">@lang('game/components/index/platformsScores.score')</th>
			    <th width="43%" class="text-center game-index-platformsScores-chart">@lang('game/components/index/platformsScores.distribution')</th>
		    </tr>
		    @foreach($game->platforms(false)->orderBy('pivot_total', 'desc')->get() as $platform)
			    <tr class="game-index-platformsScores-platformRow @if(!$platform->pivot->score) d-none @endif">
				    <td class="descriptive">@include('site.components.item.platform', ['withLink' => true]) <a href="{{ route('tag', ['platform', $platform->slug]) }}" title="@lang('game/components/index/platformsScores.see_games_of') {{ $platform->name }}">{{ $platform->name }}</a></td>
				    <td class="text-center">
					    @component('site.components.item.score', [
						    'score' => $platform->pivot->score
					    ])
					    @endcomponent
				    </td>
				    <td class="game-index-platformsScores-chart">
                        <a href="{{ route('game.ratings', [$game->slug, $platform->slug]) }}" >
                            {!! (new DistributionRatingsChart($game->ratings()->wherePlatformId($platform->id)->get()))->build() !!}
                        </a>
			        </td>
			    </tr>
		    @endforeach
		    <tr id="game-index-platformsScores-showHiddenPlatformsRow">
			    <td colspan="4">
				    <a id="game-index-platformsScores-showHiddenPlatformsButton">@lang('game/components/index/platformsScores.show_platforms_without_score') <i class="fa fa-arrow-down"></i></a>
			    </td>
		    </tr>
	    </table>
    </section>
@endif