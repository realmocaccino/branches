@extends('site.layouts.game.index')

@section('internal_content')

	<div class="row" id="game-index">
	    <div class="col-12">
            <div class="row">
                <div class="col-xl-7 col-12">
                    <div class="row">
                        <div class="col-12">
                            @include('site.game.components.index.reviews')
                        </div>
                    </div>
                    @if(!$agent->isMobile())
                        <div class="row">
                            <div class="col-12">
                                @include('site.game.components.screenshots')
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                @include('site.game.components.trailer')
                            </div>
                        </div>
                    @endif
                    <div class="row d-none d-xl-block">
                        <div class="col-12">
                            @include('site.game.components.discussions')
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-12">
                    <div class="row">
                        <div class="col-xl-12 col-md-7 col-12" style="position: relative; z-index: 1;">
                            @component('site.game.components.index.criterias', [
                                'game' => $game
                            ])
                            @endcomponent
                        </div>
                        <div class="col-xl-12 col-md-5 col-12">
                            @component('site.game.components.index.criteriasScores', [
                                'game' => $game
                            ])
                            @endcomponent
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            @component('site.game.components.index.platformsScores', [
                                'game' => $game
                            ])
                            @endcomponent
                        </div>
                    </div>
                    @if(!$agent->isMobile())
                        <div class="row">
                            <div class="col-12">
                                @component('site.game.components.ranking', [
                                    'games' => $rankingGames
                                ])
                                @endcomponent
                            </div>
                        </div>
                    @endif
                </div>
	        </div>
        </div>
	</div>

@endsection

@section('sidebar')

    <div class="row">
        <div class="col-12 order-lg-1 order-1">
            @component('site.game.components.relateds', [
                'relateds' => $relatedGames
            ])
            @endcomponent
        </div>
        @if($agent->isMobile())
            <div class="col-12 order-lg-2 order-2">
                @include('site.game.components.screenshots')
            </div>
            <div class="col-12 order-lg-3 order-3">
                @include('site.game.components.trailer')
            </div>
        @endif
        <div class="col-12 order-lg-5 order-7">
            @include('site.game.components.contributors')
        </div>
        @if(!$agent->isMobile())
            <div class="col-12 order-lg-4 order-5">
                @include('site.game.components.raters')
            </div>
        @endif
        @if($game->description)
            <div class="col-12 order-lg-6 order-4">
                @include('site.game.components.about')
            </div>
        @endif
        <div class="col-xl-12 order-lg-7 order-6">
            @include('site.game.components.details')
        </div>
        @if($agent->isMobile())
            <div class="col-xl-12 order-lg-8 order-8">
                @component('site.game.components.ranking', [
                    'games' => $rankingGames
                ])
                @endcomponent
            </div>
        @endif
    </div>

@endsection

@section('game-footer')

    <div class="row">
        <div class="col-12">
            @include('site.game.components.collections', [
                'columnsPerRow' => 'four'
            ])
        </div>
    </div>

@endsection