<form method="get">
	<div class="input-group">
		<input type="text" name="search_term" class="form-control" placeholder="{{ request('search_term', $placeholder) }}" required>
		@if(request()->has('search_term'))
			<a id="remover_busca" href="{{ url(request()->path()) }}" title="Remover busca por &ldquo;{{ request('search_term') }}&rdquo;"><i class="glyphicon glyphicon-remove"></i></a>
		@endif
		<div class="input-group-btn">
			<button class="btn btn-default" type="submit">
				<i class="glyphicon glyphicon-search"></i>
			</button>
		</div>
	</div>
	<input type="hidden" name="search_column" value="{{ $column }}">
</form>
