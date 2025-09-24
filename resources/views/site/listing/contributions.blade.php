@extends('site.layouts.internal.index')

@section('internal_counter')

	@if($total > 1)
		<strong>{{ $total }}</strong> @lang('listing/contributions.many_contributions_found')
	@elseif($total == 1)
		<strong>1</strong> @lang('listing/contributions.one_contribution_found')
	@else
        @lang('listing/contributions.no_contribution_found')
	@endif
	
@endsection

@section('internal_content')

    <div class="row">
	    <div class="col-12">
	        <div class="listing listing-threeColumns">
		        @if($total)
			        <ul class="listing-items">
				        @foreach($items as $contribution)
					        <li>@include('site.components.item.contribution')</li>
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