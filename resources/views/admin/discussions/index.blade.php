@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			<div id="busca">{!! Admin::search('Procurar Discussão') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$discussions->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="24%">{!! Admin::sort('title', 'Título', 'Ordenar por título') !!}</th>
						<th width="20%">Usuário</th>
						<th width="14%">Jogo</th>
						<th width="8%" class="text-center">Respostas</th>
						<th width="8%" class="text-center">Status</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($discussions as $discussion)
				<tr>
					<td>{!! Admin::date($discussion->extensive_updated_at) !!}</td>
					<td>{{ $discussion->title }}</td>
					<td>{{ optional($discussion->user)->name }}</td>
					<td>{{ optional($discussion->game)->name }}</td>
					<td class="text-center">
						<a href="{{ url('answers/discussion/id/'.$discussion->id) }}" title="Ver respostas de {{ $discussion->name }}">
							{{ $discussion->answers->count() }}
						</a>
					</td>
					<td class="text-center">{!! Admin::status($discussion->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'discussions.edit', $discussion->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'discussions.destroy', $discussion->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $discussions->links() }}
			</div>
		@endif
	</div>

@endsection

{{-- Admin::info('discussions', 'Procurar discussão', 'Criar Discussão', 'discussions/criacao') --}}