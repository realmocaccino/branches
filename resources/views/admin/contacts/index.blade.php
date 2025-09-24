@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Página de Contato', 'title') !!}</div>
			<div class="pull-right">{!! Admin::button('contacts.create', 'Criar Página de Contato') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$contacts->count())
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
				@foreach($contacts as $contact)
				<tr>
					<td>{!! Admin::date($contact->extensive_updated_at) !!}</td>
					<td>{{ $contact->title_pt }}</td>
					<td class="text-center">{!! Admin::status($contact->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'contacts.edit', $contact->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'contacts.destroy', $contact->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $contacts->links() }}
			</div>
		@endif
	</div>

@endsection
