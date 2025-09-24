@extends('site.layouts.internal.index')

@section('internal_content')

	@if($news)
		@foreach($news as $new)
			<div class="new">
				<div class="new-date">{{ $new->created_at->format('d/m/Y à\s H:i') }}</div>
				<h3 class="new-title">{{ $new->title }}</h3>
				<div class="new-text">{!! $new->text !!}</div>
			</div>
		@endforeach
		
		{{ $news->links() }}
	@else
		<p>Não temos novidades no momento!</p>
	@endif

@endsection
