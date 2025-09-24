@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		{!! Admin::showMessage() !!}
		@if($permission->isAdmin())
		<div class="list-group">
			<a class="list-group-item" href="{{ route('settings.edit') }}">Configurações</a>
		</div>
		<div class="list-group">
			<a class="list-group-item" href="{{ route('administrators.index') }}"><span class="badge">{{ $total['administrators'] }}</span> Administradores</a>
			<a class="list-group-item" href="{{ route('roles.index') }}"><span class="badge">{{ $total['roles'] }}</span> Papéis</a>
		</div>
		<div class="list-group">
			<a class="list-group-item" href="{{ route('plans.index') }}"><span class="badge">{{ $total['plans'] }}</span> Planos</a>
			<a class="list-group-item" href="{{ route('subscriptions.index') }}"><span class="badge">{{ $total['subscriptions'] }}</span> Assinaturas</a>
		</div>
		@endif
		<div class="list-group">
			<a class="list-group-item" href="{{ route('contributions.index') }}"><span class="badge">{{ $total['contributions'] }}</span> Contribuições</a>
			<a class="list-group-item" href="{{ route('editionRequests.index') }}"><span class="badge">{{ $total['editionRequests'] }}</span> Solicitações de Edição</a>
		</div>
		<div class="list-group">
			<a class="list-group-item" href="{{ route('characteristics.index') }}"><span class="badge">{{ $total['characteristics'] }}</span> Características</a>
			<a class="list-group-item" href="{{ route('classifications.index') }}"><span class="badge">{{ $total['classifications'] }}</span> Classificações Indicativas</a>
			<a class="list-group-item" href="{{ route('developers.index') }}"><span class="badge">{{ $total['developers'] }}</span> Desenvolvedoras</a>
			<a class="list-group-item" href="{{ route('manufacturers.index') }}"><span class="badge">{{ $total['manufacturers'] }}</span> Fabricantes</a>
			<a class="list-group-item" href="{{ route('franchises.index') }}"><span class="badge">{{ $total['franchises'] }}</span> Franquias</a>
			<a class="list-group-item" href="{{ route('genres.index') }}"><span class="badge">{{ $total['genres'] }}</span> Gêneros</a>
			<a class="list-group-item" href="{{ route('generations.index') }}"><span class="badge">{{ $total['generations'] }}</span> Gerações</a>
			<a class="list-group-item" href="{{ route('games.index') }}"><span class="badge">{{ $total['games'] }}</span> Jogos</a>
			<a class="list-group-item" href="{{ route('modes.index') }}"><span class="badge">{{ $total['modes'] }}</span> Modos de Jogo</a>
			<a class="list-group-item" href="{{ route('platforms.index') }}"><span class="badge">{{ $total['platforms'] }}</span> Plataformas</a>
			<a class="list-group-item" href="{{ route('publishers.index') }}"><span class="badge">{{ $total['publishers'] }}</span> Publicadoras</a>
			<a class="list-group-item" href="{{ route('themes.index') }}"><span class="badge">{{ $total['themes'] }}</span> Temas</a>
		</div>
		@if($permission->isAdmin())
		<div class="list-group">
			<a class="list-group-item" href="{{ route('users.index') }}"><span class="badge">{{ $total['users'] }}</span> Usuários</a>
			<a class="list-group-item" href="{{ route('ratings.index') }}"><span class="badge">{{ $total['ratings'] }}</span> Avaliações</a>
			<a class="list-group-item" href="{{ route('reviews.index') }}"><span class="badge">{{ $total['reviews'] }}</span> Análises</a>
			<a class="list-group-item" href="{{ route('criterias.index') }}"><span class="badge">{{ $total['criterias'] }}</span> Critérios de Avaliação</a>
		</div>
		<div class="list-group">
			<a class="list-group-item" href="{{ route('links.index') }}"><span class="badge">{{ $total['links'] }}</span> Links</a>
			<a class="list-group-item" href="{{ route('menus.index') }}"><span class="badge">{{ $total['menus'] }}</span> Menus</a>
			<a class="list-group-item" href="{{ route('news.index') }}"><span class="badge">{{ $total['news'] }}</span> Novidades</a>
			<a class="list-group-item" href="{{ route('institutionals.index') }}"><span class="badge">{{ $total['institutionals'] }}</span> Páginas Institucionais</a>
			<a class="list-group-item" href="{{ route('contacts.index') }}"><span class="badge">{{ $total['contacts'] }}</span> Páginas de Contato</a>
			<a class="list-group-item" href="{{ route('rules.index') }}"><span class="badge">{{ $total['rules'] }}</span> Regulamentos</a>
		</div>
		<div class="list-group">
			<a class="list-group-item" href="{{ route('advertisements.index') }}"><span class="badge">{{ $total['advertisements'] }}</span> Anúncios</a>
			<a class="list-group-item" href="{{ route('advertisers.index') }}"><span class="badge">{{ $total['advertisers'] }}</span> Anunciantes</a>
		</div>
		@endif
		<div class="list-group">
			<a class="list-group-item" href="{{ route('discussions.index') }}"><span class="badge">{{ $total['discussions'] }}</span> Discussões</a>
			<a class="list-group-item" href="{{ route('answers.index') }}"><span class="badge">{{ $total['answers'] }}</span> Respostas</a>
		</div>
	</div>

@endsection