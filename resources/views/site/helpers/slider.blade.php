<?php
$slidesToShow = in_array($slug, [
    'featured-games',
    'latest-releases',
    'next-releases'
]) ? 5 : 6;
?>
@component('site.components.title', [
	'title' => $title,
	'link' => route('list', [$slug, optional($platform)->slug]),
	'arrow' => true
])
@endcomponent
<div class="splide" data-per-page="{{ $slidesToShow }}" data-breakpoints='{
	"1199": {
		"perPage": 4
	},
	"992": {
		"perPage": 3
	},
	"768": {
		"perPage": 2
	},
	"575": {
		"perPage": 1,
		"autoWidth": true,
		"gap": 20,
		"speed": 150,
		"easing": "linear",
		"arrows": false,
		"pagination": false
	}
}'>
	<div class="splide__track">
		<ul class="splide__list slider slider-games">
			@foreach($items as $item)
				<li class="splide__slide">
					{!! view('site.components.item.game', ['game' => $item, 'coverSize' => $coverSize, 'isExtensiveRelease' => $isExtensiveRelease ?? false])->render() !!}
				</li>
			@endforeach
		</ul>
	</div>
</div>