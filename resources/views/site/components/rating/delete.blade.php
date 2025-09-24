@if($errors->all())
	{{ print_r($errors->all()) }}
@endif

<div id="rating-delete" @if(Site::getPreviousRouteName() == 'game.index' and $game->ratings()->count() == 1) data-reload="true" @endif>
	@include('site.components.rating.header')
	<div id="rating-body">
		<form id="rating-delete-form" method="post" action="{{ route('rating.delete', $game->slug) }}" data-ajax-url="{{ route('rating.ajax.delete', $game->slug) }}">
			<fieldset class="text-center">
				<p id="rating-delete-form-message">@lang('components/rating/delete.are_you_sure') {{ $game->name }}?</p>
				<div id="rating-delete-form-buttons">
					<a class="btn btn-secondary dialog-close" href="{{ url()->previous()}}">@lang('components/rating/delete.cancel')</a>
					<button type="submit" class="btn btn-outline-danger">@lang('components/rating/delete.delete')</button>
					<input type="hidden" name="origin_route" value="{{ Site::getPreviousRouteName() }}">
				</div>
				{!! csrf_field() !!}
			</fieldset>
		</form>
	</div>
</div>
