<form id="header-search-form" action="{{ route('search.games') }}" data-ajax-url="{{ route('search.ajax.games') }}" method="get">
    <input id="header-search-input" type="search" name="term" placeholder="@lang('layouts/main/header.search_placeholder')" autocomplete="off">
    <input id="header-search-submit" type="submit" value="" title="@lang('layouts/main/header.search_placeholder')">
    <input id="header-search-reset" type="reset" value="" title="@lang('layouts/main/header.search_reset')">
    <div id="header-search-loading"></div>
</form>