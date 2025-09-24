@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-followings">{{ $total }}</span></strong> @lang('user/followings.followings')
	@elseif($total == 1)
		<strong><span class="total-user-followings">1</span></strong> @lang('user/followings.following')
	@else
		@lang('user/followings.no_followings')
	@endif
	
@endsection

@section('user_content')

    <div id="user-followings">
        @if($followings->count())
	        <div class="row">
                <div class="col-12">
	                <div class="listing listing-fourColumns">
		                @if($total)
			                <ul class="listing-items">
				                @foreach($followings as $following)
					                <li>@include('site.components.item.user', [
					                    'user' => $following
					                ])</li>
				                @endforeach
			                </ul>
			                <div class="listing-pagination">
				                {{ $followings->links() }}
			                </div>
		                @endif
	                </div>
	            </div>
            </div>
        @endif
	</div>

@endsection