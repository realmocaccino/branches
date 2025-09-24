<div class="filter">
	<div class="row">
		<div class="col-12">
			<form class="filter-form" method="get">
				<button class="filter-form-toggleButton">
					<img src="{{ asset('img/filter.png') }}">
					@lang('helpers/filter.filters')
				</button>
				<div class="filter-form-order-bar-container">
					@isset($filter['orderBar'])
						{!! $filter['orderBar'] !!}
					@endisset
					@if($currentRouteName == 'ranking.games')
						<select name="year" class="ranking-filterByYear transform select-reload">
							<option value="">@lang('ranking/games.all_years')</option>
							@foreach($filter['years'] as $year)
								<option value="{{ $year }}" @if($year == $filter['selectedYear']) selected="selected" @endif>{{ $year }}</option>
							@endforeach
						</select>
					@endif
				</div>
				@isset($filter['actives'])
					<ul class="filter-actives">
						@foreach($filter['actives'] as $active)
							<li>{!! $active !!}</li>
						@endforeach
					</ul>
				@endisset
				<div class="clearfix"></div>
				<div class="filter-form-toggleTarget">
					<ul class="filter-form-filterBars">
						@isset($filter['filterBars'])
							@foreach($filter['filterBars'] as $bar)
								<li class="filter-form-filterBar">{!! $bar !!}</li>
							@endforeach
						@endisset
					</ul>
				</div>
				@isset($filter['alphabet'])
					{!! $filter['alphabet'] !!}
				@endif
				@if(request()->query('term')) <input type="hidden" name="term" value="{{ request('term') }}"> @endif
				@if(request()->query('initial')) <input type="hidden" name="initial" value="{{ request('initial') }}"> @endif
			</form>
		</div>
	</div>
</div>