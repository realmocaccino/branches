@extends('site.layouts.main.index')

@section('content-header')

    <div id="game-background" @if($game->background) style="background: linear-gradient(transparent, #FFF @if($agent->isMobile()) 245px @else 300px @endif), url('{{ $game->getBackground($agent->isMobile() ? '576x324' : '1920x1080') }}') no-repeat fixed;" @else class="noBackground" @endif></div>

@endsection

@section('content')

	<div id="game">
		<div class="container">
			<div class="row">
				<div class="col-12">
					@include('site.layouts.game.components.header')
				</div>
			</div>
			<div class="row">
				<div class="col-12" id="game-left">
					@yield('internal_content')
				</div>
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