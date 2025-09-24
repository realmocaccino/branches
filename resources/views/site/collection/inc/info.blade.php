<div class="row" id="collection-info">
    <div class="col-8">
        @component('site.components.item.user', [
			'user' => $user
		])
		@endcomponent
    </div>
    <div class="col-4">
        <div id="collection-info-share" class="float-right">
	        <p><strong>@lang('collections/collection.share'):</strong></p>
	        <ul>
		        @if($agent->isMobile())
			        <li>
				        @component('site.components.social.item', [
					        'network' => 'whatsapp',
					        'url' => 'whatsapp://send?text=' . route('collection.index', [$user->slug, $collection->slug]),
					        'title' => 'WhatsApp',
					        'size' => 'extra-small'
				        ])
				        @endcomponent
			        </li>
		        @endif
		        <li>
			        @component('site.components.social.item', [
				        'network' => 'twitter',
				        'url' => 'https://twitter.com/intent/tweet?url=' . route('collection.index', [$user->slug, $collection->slug]),
				        'title' => 'Twitter',
				        'size' => 'extra-small'
			        ])
			        @endcomponent
		        </li>
		        <li>
			        @component('site.components.social.item', [
				        'network' => 'facebook',
				        'url' => 'https://www.facebook.com/sharer/sharer.php?u=' . route('collection.index', [$user->slug, $collection->slug]),
				        'title' => 'Facebook',
				        'size' => 'extra-small'
			        ])
			        @endcomponent
		        </li>
	        </ul>
        </div>
    </div>
</div>