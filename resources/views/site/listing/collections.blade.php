@extends('site.layouts.internal.index')

@section('internal_counter')

	@if($total > 1)
		<strong>{{ $total }}</strong> @lang('listing/collections.collections')
	@elseif($total == 1)
		<strong>1</strong> @lang('listing/collections.collection')
	@else
		@lang('listing/collections.collections')
	@endif
	
@endsection

@section('internal_content')

    @if($collections->count())
        <div class="row listing listing-fourColumns">
            <div class="col-12">
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
        </div>
    @endif

@endsection