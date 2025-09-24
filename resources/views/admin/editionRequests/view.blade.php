<p>
	<strong>{{ $editionRequest->model_name }}</strong>
</p>
<p>
	{{ $entity->name }}
</p>
@foreach($changes as $field => $change)
	<p><strong><em>{{ $field }}</em></strong></p>
	<p>@if(isset($change['from']) and $change['from']) <strong>De</strong> {{ $change['from'] }} </p><p><strong>para</strong> @endif {{ $change['to'] }}</p></p>
@endforeach
<p>
	<a class="btn btn-success" href="{{ route('editionRequests.approve', $editionRequest->id) }}">
		Aprovar
	</a>
	<a class="btn btn-danger" href="{{ route('editionRequests.discard', $editionRequest->id) }}">
		Descartar
	</a>
</p>