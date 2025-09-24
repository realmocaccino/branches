@extends('site.layouts.main.index')

@section('content')
	
    <div class="row" id="home">
        <div class="col-12">
            <div class="row">
                <div class="col-12" id="home-buttons">
					<ul class="horizontalDraggable">
						@if(!$agent->isMobile())
							<li>
								<a class="btn btn-site-light" href="{{ route('premium.index') }}">
									<em class="fa fa-star"></em> @lang('home/index.premium')
								</a>
							</li>
						@endif
						{!! Menu::show('home', ['btn', 'btn-site-light']) !!}
					</ul>
		        </div>
	        </div>
			<div class="row">
				<div class="col-12" id="home-find">
					<div class="title">
						<h3>
							<label for="home-find-keywords">@lang('home/index.find_a_game_title')</label>
						</h3>
					</div>
					<form method="get" action="{{ route('find.index') }}">
						<select id="home-find-keywords" class="form-control" name="keywords[]" multiple="multiple" required="required" data-minimum-input-length="1" data-placeholder="@lang('home/index.find_a_game_placeholder')">
							<option value="" disabled>Digite palavras</option>
							@foreach($keywords as $slug => $name)
								<option value="{{ $slug }}">{{ $name }}</option>
							@endforeach
						</select>
						<button id="home-find-button" class="btn btn-site">@lang('home/index.find_a_game_search')</button>
					</form>
				</div>
			</div>
            @if($featuredsSlider)
		        <div class="row">
			        <div class="col-12 home-sliderColumn">
				        {!! $featuredsSlider !!}
			        </div>
		        </div>
	        @endif
	        @foreach($firstHalfSliders as $slider)
                <div class="row">
                    <div class="col-12 home-sliderColumn">
                        {!! $slider !!}
                    </div>
                </div>
            @endforeach
            @if($releasesSlider)
		        <div class="row">
			        <div class="col-12 home-sliderColumn">
				        {!! $releasesSlider !!}
			        </div>
		        </div>
	        @endif
            @if($featuredTrailerGame)
	            <div class="row" id="home-trailers">
	                <div class="col-12">
	                    @component('site.components.title', [
                            'title' => trans('home/index.trailers_title')
                        ])
                        @endcomponent
                        <ul id="home-trailers-list">
                            <li>
                                @component('site.components.item.trailer', [
                                    'youtubeId' => $featuredTrailerGame->trailer,
                                    'autoplay' => true
                                ])
                                @endcomponent
                            </li>
                            @component('site.components.item.game_horizontal', [
                                'game' => $featuredTrailerGame,
                                'coverSize' => '78x90',
                                'withPlatforms' => true
                            ])
                            @endcomponent
	                    </ul>
	                </div>
	            </div>
	        @endif
	        @if($upcomingsSlider)
		        <div class="row">
			        <div class="col-12 home-sliderColumn">
				        {!! $upcomingsSlider !!}
			        </div>
		        </div>
	        @endif
	        @foreach($secondHalfSliders as $slider)
                <div class="row">
                    <div class="col-12 home-sliderColumn">
                        {!! $slider !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
	
@endsection