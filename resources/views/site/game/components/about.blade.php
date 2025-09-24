@if($game->description)
    <section class="game-description">
        @component('site.components.title', [
	        'title' => trans('game/components/description.title')
        ])
        @endcomponent
	    <div class="clearfix"></div>
	    <div @if(!isset($noSumup) or !$noSumup) data-sumup="4" data-sumup-tolerance="5" @endif><span class="fa fa-quote-left"></span> {!! $game->description !!} <span class="fa fa-quote-right"></span></div> 
	    <meta itemprop="description" content="{!! $game->description !!}">
        @if($game->classification)
            <p class="game-description-classification"><strong>@lang('game/components/details.parental_rating'):</strong> <span itemprop="contentRating"><img class="game-description-classification-icon" src="{{ asset('img/classification/' . $game->classification->slug . '.jpg') }}" title="{{ $game->classification->name }}" alt="{{ $game->classification->name }}"><span></p>
        @endif
    </section>
@endif