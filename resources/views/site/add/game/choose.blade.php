@extends('site.layouts.internal.index')

@section('internal_content')

    <div id="add-game-choose">
        <div id="add-game-choose-results">
            <ul>
                @foreach($apiGames as $game)
                    <li>
                        <a href="{{ @route('add.game.queue', [$vendor, $game->id]) }}">
                            {{ $game->nameWithReleaseYear }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <a href="{{ @route('add.game.search') }}" class="btn btn-primary">@lang('add/game/choose.search_again')</a>
        <a href="{{ @route('add.game.index') }}?name={{ $name }}" class="btn btn-link add-game-insert-manually-button">@lang('add/game/search.insert_manually')</a>
	</div>

@endsection
