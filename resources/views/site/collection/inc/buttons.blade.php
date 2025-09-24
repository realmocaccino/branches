<div id="collection-buttons">
    <a class="btn btn-extra-small btn-secondary" href="{{ route('collection.orderPage', $collection->slug) }}">
        @lang('components/item/collection.order')
    </a>
    @if(!$collection->isDefault())
        <a class="btn btn-extra-small btn-secondary" href="{{ route('collection.editPage', $collection->slug) }}">
            @lang('components/item/collection.edit')
        </a>
    @endif
    <a class="btn btn-extra-small btn-danger" href="{{ route('collection.deletePage', $collection->slug) }}">
        @lang('components/item/collection.delete')
    </a>
</div>