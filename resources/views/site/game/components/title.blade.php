<div class="title {{ $class ?? null }}">
	<h3>
		@isset($link)
			<a href="{{ $link }}">
		@endisset
		{!! $title !!}
		@isset($link)
			</a>
		@endisset
	</h3>
</div>