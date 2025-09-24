@if(count($games))
	@foreach($games as $game)
		<li>@include('site.components.item.game_horizontal')</li>
	@endforeach
	@if(isset($link))
		<li class="header-search-results-more-results">
			<a href="{{ $link }}">
				<p>@lang('ajax/layouts/main/header_search_results.see_all') @lang('ajax/layouts/main/header_search_results.results')</p>
			</a>
		</li>
	@elseif(isset($term) and $total > 1)
		<li class="header-search-results-more-results">
			<a href="{{ route('search.games', ['term' => $term]) }}">
				<p>@lang('ajax/layouts/main/header_search_results.see_all') {{ $total }} @lang('ajax/layouts/main/header_search_results.results')</p>
			</a>
		</li>
	@endif
@elseif(isset($term))
	<li class="header-search-results-not-found">
		<p>@lang('ajax/layouts/main/header_search_results.no_game_found')</p>
	</li>
	<li class="header-search-results-add">
		<a href="{{ route('add.game.choose', ['name' => $term]) }}">
			<p>@lang('ajax/layouts/main/header_search_results.register') "{{ ucwords($term) }}" @lang('ajax/layouts/main/header_search_results.to_catalog')</p>
		</a>
	</li>
@endif