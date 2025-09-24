@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Página Institucional', 'title') !!}</div>
			<div class="pull-right">{!! Admin::button('institutionals.create', 'Criar Página Institucional') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$institutionals->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="70%">{!! Admin::sort('title_pt', 'Título', 'Ordenar por título') !!}</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($institutionals as $institutional)
				<tr>
					<td>{!! Admin::date($institutional->extensive_updated_at) !!}</td>
					<td>{{ $institutional->title_pt }}</td>
					<td class="text-center">{!! Admin::status($institutional->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'institutionals.edit', $institutional->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'institutionals.destroy', $institutional->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $institutionals->links() }}
			</div>
		@endif
	</div>

@endsection
