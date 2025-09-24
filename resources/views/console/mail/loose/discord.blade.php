@extends('common.layouts.mail.index')

@section('content')
    <style>
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 20px;
            background-color: #7289da;
	        color: #FFF; 
	        text-decoration: none;
            font-weight: bold;
            font-size: 15px;
        }
    </style>
    <table>
	    <tr>
	        <td>
	            <p><strong>@lang('console/mail/loose/discord.hello'), {{ $user->name }}!</strong></p>
	            <p>@lang('console/mail/loose/discord.text_1')</p>
	            <p>@lang('console/mail/loose/discord.text_2')</p>
	            <p><a class="button" href="https://discord.gg/U6XYeZz">@lang('console/mail/loose/discord.text_3')</a></p>
	        </td>
	    </tr>
	</table>
@endsection