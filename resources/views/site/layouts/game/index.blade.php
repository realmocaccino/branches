@extends('site.layouts.main.index')

@section('content-header')

	<style>
		#game-background {
			background: linear-gradient(transparent, var(--game-background-color) {{ $gradientHeight }}), url('{{ $game->getBackground($backgroundSize) }}') fixed;
		}

		.dark #game-background {
			background: linear-gradient(transparent, var(--dark-mode-game-background-color) {{ $gradientHeight }}), url('{{ $game->getBackground($backgroundSize) }}') fixed;
		}
	</style>

	<div id="game-background"></div>

@endsection

@section('content')

	<div id="game" class="container" itemscope itemtype="http://schema.org/SoftwareApplication">
		<meta itemprop="applicationCategory" content="Game">
		@if($game->ratings()->count())
			<div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<meta itemprop="bestRating" content="10">
				<meta itemprop="ratingValue" content="{{ $game->score }}">
				<meta itemprop="ratingCount" content="{{ $game->total_ratings }}">
			</div>
		@endif
		<div class="row hide-ads">
			<div class="col-12">
				@include('site.layouts.game.components.header')
			</div>
		</div>
		<div class="row">
			<div class="col-xl-9 col-12" id="game-left">
				@yield('internal_content')
			</div>
			<div class="col-xl-3 col-12" id="game-right">
				@yield('sidebar')
			</div>
		</div>
		@hasSection('game-footer')
		    <div class="row">
	            <div class="col-12">
	                @yield('game-footer')
	            </div>
	        </div>
	    @endif
	</div>

@endsection