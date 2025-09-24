@extends('site.layouts.game.index')

@section('internal_content')

	<div class="row" id="game-index">
	    <div class="col-12">
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
            <div class="row">
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
            @include('site.game.components.about')
        </div>
    </div>
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
            @include('site.game.components.details')
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @include('site.game.components.contributors')
        </div>
    </div>

@endsection