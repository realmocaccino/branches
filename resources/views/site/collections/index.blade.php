@extends('site.layouts.internal.index')

@section('internal_counter')

	@if($total > 1)
		<strong>{{ $total }}</strong> @lang('collections/index.many_collections_found')
	@elseif($total == 1)
		<strong>1</strong> @lang('collections/index.one_collection_found')
	@else
		@lang('collections/index.no_collection_found')
	@endif
	
@endsection

@section('internal_content')

	<div id="collections">
	    <div class="row" id="collections-search">
		    <div class="col-12">
			    <form class="form-inline" method="get" action="{{ route('collections.search') }}" id="collections-search-form">
				    <div class="form-group">
					    <input id="collections-search-form-input" class="form-control" type="text" name="term" placeholder="@lang('collections/index.search_collections')" required>
					    <button id="collections-search-form-button" class="btn btn-sm btn-site" type="submit">@lang('collections/index.search')</button>
				    </div>
			    </form>
		    </div>
	    </div>
		<div class="row">
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
	</div>

@endsection