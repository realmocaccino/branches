@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Novidade', 'title') !!}</div>
			<div class="pull-right">{!! Admin::button('news.create', 'Criar Novidade') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$news->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="70%">{!! Admin::sort('title', 'Título', 'Ordenar por título') !!}</th>
						<th width="6%" class="text-center">Status</th>
						<th width="6%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($news as $new)
				<tr>
					<td>{!! Admin::date($new->extensive_updated_at) !!}</td>
					<td>{{ $new->title }}</td>
					<td class="text-center">{!! Admin::status($new->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'news.edit', $new->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'news.destroy', $new->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $news->links() }}
			</div>
		@endif
	</div>

@endsection
