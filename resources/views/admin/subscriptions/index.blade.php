@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Assinaturas') !!}</div>
			<div class="pull-right">{!! Admin::button('subscriptions.create', 'Criar Assinatura') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$subscriptions->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="14%">Plano</th>
						<th width="22%">Usuário</th>
						<th width="18%" class="text-center">{!! Admin::sort('paid', 'Pagou', 'Ordenar por preço pago') !!}</th>
						<th width="20%">{!! Admin::sort('expires_at', 'Expira em', 'Ordenar por data de expiração') !!}</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($subscriptions as $subscription)
				<tr>
					<td>{!! Admin::date($subscription->extensive_updated_at) !!}</td>
					<td>{{ optional($subscription->plan)->name }}</td>
					<td>@isset($subscription->user) {{ $subscription->user->name }} @endisset</td>
					<td class="text-center">{{ $subscription->paid }}</td>
					<td>{{ $subscription->expires_at->format('d/m/Y \à\s h:i') }}</td>
					<td class="text-center">{!! Admin::action('edit', 'subscriptions.edit', $subscription->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'subscriptions.destroy', $subscription->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $subscriptions->links() }}
			</div>
		@endif
	</div>

@endsection