<ul class="slider" data-slider="@isset($options) {{ json_encode($options, JSON_HEX_APOS) }} @endisset">
	@foreach($slides as $slide)
		<li>
			{!! $slide !!}
		</li>
	@endforeach
</ul>
