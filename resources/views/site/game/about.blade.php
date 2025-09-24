@extends('site.layouts.game.index')

@section('internal_content')

    <div class="row" id="game-about-page">
        <div class="col-lg-12 col-12">
	        <div class="row">
                <div class="col-12">
                    @component('site.game.components.title', [
		                'title' => trans('game/about.title')
	                ])
	                @endcomponent
                </div>
            </div>
	        <div class="row">
                <div class="col-12">
                    @include('site.game.components.about')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('site.game.components.screenshots_mosaic', [
                        'screenshots' => $game->screenshots
                    ])
                </div>
            </div>
        </div>
    </div>

@endsection