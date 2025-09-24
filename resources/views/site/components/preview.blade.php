@if(count($items))
    <div class="preview">
        @isset($title)
            @component('site.components.title', [
                'title' => $title,
                'link' => $link ?? null
            ])
            @endcomponent
        @endif
		<ul>
			@foreach($items as $item)
				<li>
					@component($thumbnail_view, [
						'user' => $item,
						'size' => '150x150'
					])
					@endcomponent
				</li>
			@endforeach
			@if($total > count($items))
			    <li class="preview-more">
			        <a href="{{ $link }}" title="@lang('components/preview.see_all')">
			            +{{ $total - count($items) }}
			        </a>
			    </li>
			@endif
		</ul>
		<div class="clearfix"></div>
    </div>
@endif