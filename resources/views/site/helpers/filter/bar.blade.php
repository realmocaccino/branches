<select name="{{ $filter }}[]" multiple="multiple" data-placeholder="{{ ucwords(trans('helpers/filter/bar.' . $filter)) }}">
	@foreach($query as $item)
		<option value="{{ $item->slug }}" @if(in_array($item->slug, $actives)) selected="selected" @endif>{{ $item->name }}</option>
	@endforeach
</select>
