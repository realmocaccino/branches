@extends('common.layouts.mail.index')

@section('content')
	<p>Obrigado por se cadastrar, {{ $user->name }}!</p>
	<p>No <a href="{{ route('home') }}">{{ $settings->name }}</a> você tem acesso a milhares de avaliações e análises de jogos realizadas pelos usuários.</p>
	<p><img src="{{ asset('img/mail/welcome/rate.jpg') }}"></p>
	<p>Nosso diferencial é que a avaliação é baseada em critérios, não em uma simples nota. Isso proporciona mais informações ao usuário que deseja adquirir um jogo.</p>
	<p><img src="{{ asset('img/mail/welcome/rating.jpg') }}"></p>
	<p>Explorando nosso <a href="{{ route('home') }}">catálogo</a> e filtrando os resultados, você pode descobrir um jogo que atenda seu gosto.</p>
	<p><img src="{{ asset('img/mail/welcome/catalog.jpg') }}"></p>
	<p>Tratamos com cuidado a ficha técnica dos jogos, trazendo além dos dados básicos, informações sobre o tema e características do game, modos de jogo, bem como suas capturas de tela e trailer de lançamento.</p>
	<p>Caso não encontre um determinado jogo, você pode <a href="{{ route('add.game.index') }}">incluir</a> em nosso catálogo, contribuindo e ganhando destaque na comunidade.</p>
	<p>A <a href="{{ route('community') }}">página da comunidade</a> é o local onde quem mais avalia, analisa ou contribui para jogos, ganha notoriedade!</p>
	<p><img src="{{ asset('img/mail/welcome/community.jpg') }}"></p>
	<p>Qualquer dúvida ou sugestão, não hesite em entrar em <a href="{{ route('contact.index', ['suporte']) }}">contato</a> conosco =)</p>
@endsection
