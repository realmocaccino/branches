@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Anúncio') !!}</div>
			<div class="pull-right">{!! Admin::button('advertisements.create', 'Criar Anúncio') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$advertisements->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="21%">{!! Admin::sort('name', 'Nome', 'Ordenar por nome') !!}</th>
						<th width="21%">{!! Admin::sort('slug', 'Slug', 'Ordenar por slug') !!}</th>
						<th width="14%">Anunciante</th>
						<th width="14%">Plataforma</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($advertisements as $advertisement)
				<tr>
					<td>{!! Admin::date($advertisement->extensive_updated_at) !!}</td>
					<td>{{ $advertisement->name }}</td>
					<td>{{ $advertisement->slug }}</td>
					<td>{{ $advertisement->advertiser->name }}</td>
					<td>{{ $platforms[$advertisement->platform] }}</td>
					<td class="text-center">{!! Admin::status($advertisement->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'advertisements.edit', $advertisement->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'advertisements.destroy', $advertisement->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $advertisements->links() }}
			</div>
		@endif
	</div>

@endsection
