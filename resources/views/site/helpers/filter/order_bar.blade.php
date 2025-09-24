<select class="filter-form-order-bar transform" name="order" data-placeholder="@lang('helpers/filter/order_bar.sort')">
	<option selected value="default">@if($current != 'default') @lang('helpers/filter/order_bar.default') @else @lang('helpers/filter/order_bar.sort') @endif</option>
	@foreach($orders as $slug => $name)
		<option value="{{ $slug }}" @if($current == $slug) selected="selected" @endif>{{ $name }}</option>
	@endforeach
</select>