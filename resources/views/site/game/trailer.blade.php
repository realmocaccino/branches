@extends('site.layouts.game.index')

@section('internal_content')

    <div class="row" id="game-trailer-page">
	    <div class="col-12">
	        @if($game->trailer)
		        @component('site.game.components.trailer', [
                    'game' => $game,
                    'autoplay' => true
                ])
                @endcomponent
            @endif
	    </div>
    </div>

@endsection