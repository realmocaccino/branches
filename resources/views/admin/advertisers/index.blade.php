@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Anunciante') !!}</div>
			<div class="pull-right">{!! Admin::button('advertisers.create', 'Criar Anunciante') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$advertisers->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="50%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="12%" class="text-center">Anúncios</th>
						<th width="10%" class="text-center">Status</th>
						<th width="10%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($advertisers as $advertiser)
				<tr>
					<td>{!! Admin::date($advertiser->extensive_updated_at) !!}</td>
					<td>{{ $advertiser->name }}</td>
					<td class="text-center">
						<a href="{{ url('advertisements/advertisers/slug/'.$advertiser->slug) }}" title="Ver anúncios de {{ $advertiser->name }}">
							{{ $advertiser->advertisements->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($advertiser->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'advertisers.edit', $advertiser->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'advertisers.destroy', $advertiser->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $advertisers->links() }}
			</div>
		@endif
	</div>

@endsection
