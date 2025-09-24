@extends('common.layouts.mail.index')

@section('content')
    <table>
	    <tr>
	        <td width="25%">
	            <a href="{{ route('game.index', [$game->slug]) }}">
	                <img src="{{ $game->getCover('110x136') }}" alt="@lang('console/mail/warn_me.game_cover_alt') {{ $game->name }}">
	            </a>
	        </td>
	        <td width="75%" style="padding-left: 0;">
	            <p>@lang('console/mail/warn_me.hello'), {{ $user->name }}!</p>
	            <p>{!! $text !!} @lang('console/mail/warn_me.on') {{ $settings->name }}.</p>
	        </td>
	    </tr>
	</table>
@endsection
