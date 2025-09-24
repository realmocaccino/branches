@extends('common.layouts.mail.index')

@section('content')
    <style>
		table#wrapper tr#content td {
			padding: 30px;
		}
	</style>
	<h1>@lang('console/mail/releases_of_the_week.title')</h1>
	<table>
	@foreach($games as $game)
	    <tr>
	        <td width="25%">
	            <a href="{{ route('game.index', [$game->slug]) }}">
	                <img src="{{ $game->getCover('110x136') }}" alt="@lang('console/mail/releases_of_the_week.game_cover_alt') {{ $game->name }}">
	            </a>
	        </td>
	        <td width="75%" style="padding-left: 0;">
	            <p>
	                <a href="{{ route('game.index', [$game->slug]) }}">
	                    {{ $game->name }}
	                </a>
	            </p>
	            <p>
	                {{ strftime('%A (%d/%m)', strtotime($game->release)) }}
	            </p>
	            <p>
	                @foreach($game->platforms as $platform)
					    @include('site.components.item.platform')
				    @endforeach
				</p>
	            <p>
	                {!! str_limit($game->description, 70) !!}
	            </p>
	        </td>
	    </tr>
	@endforeach
	</table>
@endsection