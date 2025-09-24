@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong>{{ $total }}</strong> @lang('user/collections.collections')
	@elseif($total == 1)
		<strong>1</strong> @lang('user/collections.collection')
	@else
		@lang('user/collections.collections')
	@endif
	
@endsection

@section('user_content')

    <div id="user-collections" class="row">
	    <div class="col-12">
	        @if($collections->count())
	            <div class="listing listing-fiveColumns">
	                <ul class="listing-items">
                        @foreach($collections as $collection)
                            <li>
                                @component('site.components.item.collection', [
	                                'collection' => $collection
                                ])
                                @endcomponent
                            </li>
                        @endforeach
                    </ul>
	                <div class="listing-pagination">
			            {{ $collections->links() }}
		            </div>
		        </div>
	        @endif
        </div>
	</div>

@endsection