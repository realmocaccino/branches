<div class="ad @if($local) ad-local @endif" style="@if(!$responsive) @if($width) width: {{ $width }}; @endif @if($height) height: {{ $height }}; @endif @endif @if($style) {{ $style }} @endif">
	@if($local)
		Publicidade
	@elseif($code)
		@if($advertiserScript) <script async src="{{ $advertiserScript }}"></script> @endif
		{!! $code !!}
	@endif
</div>
