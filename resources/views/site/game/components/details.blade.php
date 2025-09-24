<section id="game-details">
    <div class="row">
        <div class="col-12">
	        @component('site.components.title', [
		        'title' => trans('game/components/details.title')
	        ])
	        @endcomponent
	    </div>
	</div>
	<div class="row">
        <div class="col-12">
            <table class="table">
                <tr id="game-details-name">
                    <td>@lang('game/components/details.name')</td>
                    <td itemprop="name">{{ $game->name }}</td>
                </tr>
                @if($game->alias)
                    <tr id="game-details-alternativeName">
                        <td>@lang('game/components/details.alternative_name')</td>
                        <td>{{ $game->alias }}</td>
                    </tr>
                @endif
                @if(!$game->isUndated())
                    <tr id="game-details-releaseDate">
                        <td>@lang('game/components/details.release_date')</td>
                        <td itemprop="datePublished">{{ $game->release->format('d/m/Y') }}</td>
                    </tr>
                @endif
                @if($game->platforms->count())
                    <tr id="game-details-platforms">
                        <td>{{ str_plural(trans('game/components/details.platform'), $game->platforms->count()) }}</td>
                        <td>
                            {!! Site::tagLinkCollection('platform', $game->platforms, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                @if($game->genres->count())
                    <tr id="game-details-genres">
                        <td>{{ str_plural(trans('game/components/details.genre'), $game->genres->count()) }}</td>
                        <td>
                            {!! Site::tagLinkCollection('genre', $game->genres, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                @if($game->modes->count())
                    <tr id="game-details-modes">
                        <td>{{ str_plural(trans('game/components/details.mode'), $game->modes->count()) }}</td>
                        <td>
                            {!! Site::tagLinkCollection('mode', $game->modes, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                @if($game->characteristics->count())
                    <tr id="game-details-characteristics">
                        <td>{{ trans('game/components/details.characteristics') }}</td>
                        <td>
                            {!! Site::tagLinkCollection('characteristic', $game->characteristics, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                @if($game->themes->count())
                    <tr id="game-details-themes">
                        <td>{{ str_plural(trans('game/components/details.theme'), $game->themes->count()) }}</td>
                        <td>
                            {!! Site::tagLinkCollection('theme', $game->themes, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                @if($game->developers->count())
                    <tr id="game-details-developers">
                        <td>{{ str_plural(trans('game/components/details.developer'), $game->developers->count()) }}</td>
                        <td>
                            {!! Site::tagLinkCollection('developer', $game->developers, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                @if($game->publishers->count())
                    <tr id="game-details-publishers" itemscope itemtype="http://schema.org/Organization" itemprop="publisher">
                        <meta itemprop="name" content="{{ $game->publishers()->first()->name }}">
                        <td>{{ str_plural(trans('game/components/details.publisher'), $game->publishers->count()) }}</td>
                        <td>{!! Site::tagLinkCollection('publisher', $game->publishers, 'dark', 'badge') !!}</td>
                    </tr>
                @endif
                @if($game->franchises->count())
                    <tr id="game-details-franchises">
                        <td>{{ str_plural(trans('game/components/details.franchise'), $game->franchises->count()) }}</td>
                        <td>
                            {!! Site::tagLinkCollection('franchise', $game->franchises, 'dark', 'badge') !!}
                        </td>
                    </tr>
                @endif
                <tr id="game-details-correct">
                    <td colspan="2">
                        <a href="{{ route('game.edition.index', $game->slug) }}">@lang('game/components/details.correct_data')</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>