@extends((isset($game) and !$agent->isMobile()) ? 'site.layouts.game.index' : 'site.layouts.internal.index', [
	'noTitle' => ($currentRouteName == 'game.forum.discussion')
])

@section('internal_content')

	<div class="row">
		<div class="col-12">
			@yield('forum_content')
		</div>
	</div>

@endsection