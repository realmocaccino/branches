@extends('site.layouts.user.index')

@section('user_counter')

	@if($total > 1)
		<strong><span class="total-user-contributions">{{ $total }}</span></strong> @lang('user/contributions.contributed_games')
	@elseif($total == 1)
		<strong><span class="total-user-contributions">1</span></strong> @lang('user/contributions.contributed_game')
	@else
		@lang('user/contributions.no_contributed_games')
	@endif
	
@endsection

@section('user_content')

    <div id="user-contributions">
        @if($contributions->count())
	        <div class="row listing listing-threeColumns">
		        <div class="col-12">
			        <ul class="listing-items">
				        @foreach($contributions as $contribution)
						    <li>
							   @component('site.components.item.contribution', [
							        'contribution' => $contribution,
							        'cover' => 'game'
						        ])
						        @endcomponent
						    </li>
					    @endforeach
			        </ul>
			        <div class="listing-pagination">
			            {{ $contributions->links() }}
		            </div>
		        </div>
	        </div>
        @endif
	</div>

@endsection