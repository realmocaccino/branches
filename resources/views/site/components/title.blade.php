<div class="title {{ $class ?? null }}">
	<h3>
		@isset($link)
			<a href="{{ $link }}">
		@endisset
		{!! $title !!} @if(isset($arrow) and $arrow) <em class="fa fa-arrow-right title-arrow"></em> @endif
		@isset($link)
			</a>
		@endisset
	</h3>
</div>