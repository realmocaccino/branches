@isset($platforms)
	<option value="">Selecione a plataforma</option>
	@foreach($platforms as $id => $name)
		<option value="{{ $id }}">{{ $name }}</option>
	@endforeach
@endisset
