@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-followers">{{ $total }}</span></strong> @lang('user/followers.followers')
	@elseif($total == 1)
		<strong><span class="total-user-followers">1</span></strong> @lang('user/followers.follower')
	@else
		@lang('user/followers.no_followers')
	@endif
	
@endsection

@section('user_content')

    <div id="user-followers">
        @if($followers->count())
	        <div class="row">
                <div class="col-12">
	                <div class="listing listing-fourColumns">
		                @if($total)
			                <ul class="listing-items">
				                @foreach($followers as $follower)
					                <li>@include('site.components.item.user', [
					                    'user' => $follower
					                ])</li>
				                @endforeach
			                </ul>
			                <div class="listing-pagination">
				                {{ $followers->links() }}
			                </div>
		                @endif
	                </div>
	            </div>
            </div>
        @endif
	</div>

@endsection