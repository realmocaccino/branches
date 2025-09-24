@extends('site.layouts.internal.index')

@section('internal_counter')

	@if($total > 1)
		<strong>{{ $total }}</strong> @lang('listing/users.many_users_found')
	@elseif($total == 1)
		<strong>1</strong> @lang('listing/users.one_user_found')
	@else
		@lang('listing/users.no_user_found')
	@endif
	
@endsection

@section('internal_content')

    <div class="row">
        <div class="col-12">
	        <div class="listing listing-fourColumns">
		        @if($total)
			        <ul class="listing-items">
				        @foreach($items as $user)
					        <li>@include('site.components.item.user')</li>
				        @endforeach
			        </ul>
			        <div class="listing-pagination">
				        {{ $items->links() }}
			        </div>
		        @endif
	        </div>
	    </div>
    </div>

@endsection