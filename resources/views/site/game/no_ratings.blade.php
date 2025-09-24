@extends('site.layouts.game.index')

@section('internal_content')

	<div class="row" id="game-index">
	    <div class="col-12">
	        @if(false and $game->isAvailable())
                <div class="row">
                    <div class="col-12" id="game-index-noRatings">
                        @include('site.components.neutral_face')
                        <p>@lang('game/components/index/scores.no_data_text')</p>
                        <p><a class="dialog btn btn-sm btn-primary" href="{{ route('rating.index', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.index', $game->slug) }}">@lang('game/components/index/scores.submit_rating')</a> @lang('game/components/index/scores.enable_data')</p>
                        </p>
                    </div>
                </div>
            @endif
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
            <div class="row d-none d-xl-block">
                <div class="col-12">
                    @include('site.game.components.discussions')
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('site.game.components.collections', [
                        'columnsPerRow' => 'three'
                    ])
                </div>
            </div>
        </div>
	</div>

@endsection

@section('sidebar')

    <div class="row">
        <div class="col-12">
            @component('site.game.components.relateds', [
                'relateds' => $relatedGames
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
            @include('site.game.components.details')
            @include('site.game.components.contributors')
        </div>
    </div>

@endsection