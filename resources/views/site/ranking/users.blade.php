@extends('site.layouts.internal.index')

@section('internal_content')

	<div class="row ranking ranking-users">
	    <div class="col-12">
	        <div class="row">
	            <div class="col-12 ranking-users-filter">
	                <a href="{{ route('ranking.users', $daysRange != 7 ? 7 : null) }}" class="btn btn-small btn-outline-info {{ ($daysRange == 7) ? 'active' : '' }}">7 @lang('ranking/users.days') @if($daysRange == 7) <em class="fa fa-close"></em> @endif</a>
	                <a href="{{ route('ranking.users', $daysRange != 30 ? 30 : null) }}" class="btn btn-small btn-outline-info {{ ($daysRange == 30) ? 'active' : '' }}">30 @lang('ranking/users.days') @if($daysRange == 30) <em class="fa fa-close"></em> @endif</a>
	                <a href="{{ route('ranking.users', $daysRange != 90 ? 90 : null) }}" class="btn btn-small btn-outline-info {{ ($daysRange == 90) ? 'active' : '' }}">90 @lang('ranking/users.days') @if($daysRange == 90) <em class="fa fa-close"></em> @endif</a>
	                <a href="{{ route('ranking.users', $daysRange != 365 ? 365 : null) }}" class="btn btn-small btn-outline-info {{ ($daysRange == 365) ? 'active' : '' }}">1 @lang('ranking/users.year') @if($daysRange == 365) <em class="fa fa-close"></em> @endif</a>
	            </div>
	        </div>
	        <div class="row">
		        <div class="col-12">
			        <table class="table">
				        <thead>
					        <tr>
						        <th width="5%" class="text-center">@lang('ranking/users.position')</th>
						        <th width="77%">@lang('ranking/users.user')</th>
						        <th width="18%" class="text-center">@lang('ranking/users.total')</th>
					        </tr>
				        </thead>
				        <tbody>
					        @foreach($users as $user)
						        <tr>
							        <td class="ranking-pos">
								        <div class="rankingPosition">{{ ++$startingPosition . 'º' }}</div>
							        </td>
							        <td class="ranking-item">
							            @component('site.components.item.user', [
                                            'user' => $user
                                        ])
                                        @endcomponent
							        </td>
							        <td class="ranking-score text-center">
								        <span class="badge badge-info">{{ $user->total }} @lang('ranking/users.pts')<span>
							        </td>
						        </tr>
					        @endforeach
				        </tbody>
			        </table>
			        <div class="ranking-pagination">
				        {{ $users->links() }}
			        </div>
		        </div>
		    </div>
		</div>
	</div>

@endsection