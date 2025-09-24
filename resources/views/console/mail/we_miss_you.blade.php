@extends('common.layouts.mail.index')

@section('content')
    <style>
		table#wrapper tr#content td {
			padding: 30px;
		}
	</style>
    <table>
	    <tr>
	        <td colspan="2">
	            <p>@lang('console/mail/we_miss_you.hello'), {{ $user->name }}!</p>
	            <p>@lang('console/mail/we_miss_you.text')</p>
	        </td>
	    </tr>
	    @foreach($games as $game)
	    <tr>
	        <td width="25%">
	            <a href="{{ route('game.index', [$game->slug]) }}">
	                <img src="{{ $game->getCover('110x136') }}" alt="@lang('console/mail/we_miss_you.game_cover_alt') {{ $game->name }}">
	            </a>
	        </td>
	        <td width="75%" style="padding-left: 0;">
	            <p>
	                <a href="{{ route('game.index', [$game->slug]) }}">
	                    {{ $game->name }}
	                </a>
	            </p>
	            <p>
	                {!! $game->description !!}
	            </p>
	        </td>
	    </tr>
	@endforeach
	</table>
@endsection
