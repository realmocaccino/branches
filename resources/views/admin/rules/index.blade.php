@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Regulamento', 'title') !!}</div>
			<div class="pull-right">{!! Admin::button('rules.create', 'Criar Regulamento') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$rules->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="35%">{!! Admin::sort('title', 'Título', 'Ordenar por título') !!}</th>
						<th width="35%">{!! Admin::sort('url', 'URL', 'Ordenar por URL') !!}</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($rules as $rule)
				<tr>
					<td>{!! Admin::date($rule->extensive_updated_at) !!}</td>
					<td>{{ $rule->title }}</td>
					<td>{{ $rule->slug }}</td>
					<td class="text-center">{!! Admin::status($rule->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'rules.edit', $rule->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'rules.destroy', $rule->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $rules->links() }}
			</div>
		@endif
	</div>

@endsection
