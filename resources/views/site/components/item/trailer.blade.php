<div class="item-trailer">
    <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}?@if(!$agent->isMobile() and (isset($autoplay) and $autoplay))autoplay=1&loop=1&mute=1&playlist={{ $youtubeId }}@endif" allowfullscreen></iframe>
</div>