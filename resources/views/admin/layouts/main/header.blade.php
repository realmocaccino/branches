<div id="topo">
	<div class="container">
		<a href="{{ url('/') }}" class="btn" id="nome-site">
			Admin - {{ $settings->name }}
		</a>
		<div class="btn-group pull-right">
			<a class="btn btn-primary" href="{{ $settings->url }}" target="_blank">Visualizar Site</a>
			@if($permission and $permission->isAdmin())
				<a class="btn btn-primary" href="{{ route('routine.clean_cache') }}">Limpar Cache</a>
			@endif
			@if(Auth::guard('admin')->check())
				<a class="btn btn-primary" href="{{ route('account.edit') }}">Editar Conta</a>
				<a class="btn btn-primary" href="{{ route('logout') }}">Sair</a>
			@endif
		</div>
	</div>
</div>
<div id="titulo-site">
	<div class="container">
		{{ $head->getTitle() }}
	</div>
</div>
