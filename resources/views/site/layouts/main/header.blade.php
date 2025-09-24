<div class="row">
    <div class="col-1" id="header-menu-mobile">
	    <a id="header-menu-mobile-button"></a>
    </div>
    <div class="col-lg-1 col-1" id="header-brand">
        @include('site.components.brand')
        <div id="header-language">
			<span>{{ config('site.locale') }}</span>
			<ul id="header-language-menu">
			    <li><a href="{{ Site::changeLanguageLink('pt') }}">PT</a></li>
                <li><a href="{{ Site::changeLanguageLink('en') }}">EN</a></li>
			</ul>
		</div>
        <a id="header-mode"></a>
    </div>
    <div class="col-lg-5" id="header-menu">
	    <ul>
		    {!! Menu::show('header') !!}
	    </ul>
    </div>
    <div class="col-lg-5 col-9" id="header-search">
	    @include('site.layouts.main.header_search')
    </div>
    <div class="col-1" id="header-search-mobile-button-container">
        <svg id="header-search-mobile-button" viewBox="0 0 40 40" class="icon icon-search" viewBox="0 0 32 32" aria-hidden="true"><path d="M27 24.57l-5.647-5.648a8.895 8.895 0 0 0 1.522-4.984C22.875 9.01 18.867 5 13.938 5 9.01 5 5 9.01 5 13.938c0 4.929 4.01 8.938 8.938 8.938a8.887 8.887 0 0 0 4.984-1.522L24.568 27 27 24.57zm-13.062-4.445a6.194 6.194 0 0 1-6.188-6.188 6.195 6.195 0 0 1 6.188-6.188 6.195 6.195 0 0 1 6.188 6.188 6.195 6.195 0 0 1-6.188 6.188z"/></svg>
    </div>
    <div class="col-lg-1 col-1" id="header-user">
	    @include('site.ajax.layouts.main.header_user', [
		    'user' => Auth::guard('site')->user()
	    ])
    </div>
</div>
<ul id="header-search-results">
    @if(isset($defaultSearchGames))
        @component('site.ajax.layouts.main.header_search_results', [
            'games' => $defaultSearchGames,
            'link' => route('list', 'popular-games')
        ])
        @endcomponent
    @endif
</ul>
<div id="header-overlay" class="overlay"></div>
