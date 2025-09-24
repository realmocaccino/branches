<option value="">Selecione a plataforma</option>
@foreach($plataformas as $plataforma)
	<option value="{{ $plataforma->id }}">{{ $plataforma->nome }}</option>
@endforeach
