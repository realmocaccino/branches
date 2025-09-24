<a href="{{ $url }}" class="btn platform-btn @if(isset($active) and $active) active @endif" @if(isset($active) and $active) title="@lang('components/item/platform_btn.clear')" @endif>
	@include('site.components.item.platform', ['noTitle' => true])
	<span class="platform-btn-name">{{ $platform->name }}</span>
	<span class="platform-btn-initials">{{ $platform->initials }}</span>
	@if(isset($active) and $active) <em class="fa fa-close"></em> @endif
</a>