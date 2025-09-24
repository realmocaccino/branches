<ul class="filter-alphabet">
	@foreach($initials as $initial)
		<li>
			<a href="{{ $url }}initial={{ $initial }}" @if((string) $initial == $currentInitial) class="active" @endif>{{ $initial }}</a>
		</li>
	@endforeach
</ul>