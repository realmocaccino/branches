@if(isset($withLink) and $withLink == true)
	<a href="{{ route('tag', ['platform', $platform->slug]) }}">
@endif
	@if($platform->logo)
		<img class="item-platform" src="{{ $platform->getLogo($logoSize ?? '32x32') }}" alt="{{ $platform->initials }}" @if(!isset($noTitle) or $noTitle == false) title="{{ $platform->name }}" @endif>
	@else
		<span title="{{ $platform->name }}">{{ $platform->initials }}</span>
	@endif
@if(isset($withLink) and $withLink == true)
	</a>
@endif