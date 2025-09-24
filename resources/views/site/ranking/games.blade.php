@extends('site.layouts.internal.index')

@section('internal_content')
	
	<div class="row">
        <div class="col-12">
	        @if(isset($filter) and $filter)
				@component('site.helpers.filter', [
					'filter' => $filter
				])
				@endcomponent
			@endisset
        </div>
    </div>
    <div class="row ranking ranking-games">
		<div class="col-12">
	        @if($games->count())
		        <table class="table">
			        <thead>
				        <tr>
					        <th width="5%" class="text-center">@lang('ranking/games.position')</th>
					        <th width="81%">@lang('ranking/games.game')</th>
					        <th width="14%" class="text-center">@lang('ranking/games.score')</th>
				        </tr>
			        </thead>
			        <tbody>
				        @foreach($games as $game)
					        <tr>
						        <td class="ranking-pos">
							        <div class="rankingPosition">{{ ++$startingPosition . 'º' }}</div>
						        </td>
						        <td class="ranking-item">
						            @component('site.components.item.game_short', [
	                                    'game' => $game,
	                                    'withoutScore' => true
                                    ])
                                    @endcomponent
						        </td>
						        <td class="ranking-score text-center">
							        @component('site.components.item.score', [
								        'score' => $game->score
							        ])
							        @endcomponent
						        </td>
					        </tr>
				        @endforeach
			        </tbody>
		        </table>
		        <div class="ranking-pagination">
		        	{{ $games->links() }}
		        </div>
	        @else
		        <p>@lang('ranking/games.no_game_found')</p>
	        @endif
	    </div>
	</div>

@endsection