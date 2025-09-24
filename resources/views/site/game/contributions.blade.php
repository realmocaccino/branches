@extends('site.layouts.game.index')

@section('internal_content')

    <div class="row" id="game-contributions-page">
	    <div class="col-12">
	        @if($game->contributions)
	            @component('site.components.title', [
	                'title' => trans('game/contributions.contributions')
                ])
                @endcomponent
                <div class="listing listing-threeColumns">
	                <ul class="listing-items">
		                @foreach($game->contributions as $contribution)
			                <li>@include('site.components.item.contribution', [
				                'cover' => 'user'
			                ])</li>
		                @endforeach
	                </ul>
                </div>
            @endif
	    </div>
    </div>

@endsection