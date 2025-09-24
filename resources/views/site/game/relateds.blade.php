@extends('site.layouts.game.open')

@section('internal_content')

    <div class="row" id="game-relateds-page">
		<div class="col-12">
            <div class="row">
                <div class="col-12">
                    @component('site.components.title', [
		                'title' => trans('game/relateds.internal_title')
	                ])
	                @endcomponent
	            </div>
	        </div>
            <div class="row listing listing-games listing-fiveColumns">
                <div class="col-12">
		            <ul class="listing-items">
			            @foreach($games as $relatedGame)
				            <li>@include('site.components.item.game', [
				                'game' => $relatedGame
				            ])</li>
			            @endforeach
		            </ul>
                </div>
            </div>
        </div>
    </div>
    
@endsection