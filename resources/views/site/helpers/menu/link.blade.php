<li>
	<a href="{{ $url }}" @if($link->target) target="{{ $link->target }}" @endif class="@if($current) active @endif @if($classes) {{ $classes }} @endif">
		{{ $link->name }}
	</a>
</li>