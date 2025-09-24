<div id="home-search">
    <form id="home-search-form" action="{{ route('search.games') }}" data-ajax-url="{{ route('search.ajax.games') }}" method="get">
        <input id="home-search-input" type="search" name="term" placeholder="@lang('home/components/search.placeholder')" autocomplete="off">
        <input id="home-search-reset" type="reset" value="" title="@lang('home/components/search.reset')">
        <div id="home-search-loading"></div>
    </form>
    <ul id="home-search-results"></ul>
</div>