@extends('site.layouts.game.index')

@section('internal_content')

	<div class="row" id="game-screenshots-page">
		<div class="col-12">
			@include('site.game.components.screenshots_mosaic', [
				'screenshots' => $game->screenshots()->get()
			])
		</div>
	</div>

@endsection