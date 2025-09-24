<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
@if($agent->isMobile())
	<script src="{{ asset('js/jquery.touchSwipe.min.js') }}"></script>
	<script>
		if('serviceWorker' in navigator) {
			navigator.serviceWorker.register('service-worker.js');
		}
	</script>
@endif
@if($head->getScripts())
	@foreach($head->getScripts() as $script)
		<script src="{{ $script }}"></script>
	@endforeach
@endif
<script src="{{ asset(Site::getCompiledFilename('js')) }}" defer></script>
{!! $settings->analytics !!}