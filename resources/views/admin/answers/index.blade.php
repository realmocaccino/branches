@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			{!! Admin::showMessage() !!}
		@if(!$answers->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="26%">Usuário</th>
						<th width="40%">Discussão</th>
						<th width="8%" class="text-center">Status</th>
						<th width="8%" class="text-center" colspan="2">Ações</th>
					</tr>
				</thead>
				@foreach($answers as $answer)
				<tr>
					<td>{!! Admin::date($answer->extensive_updated_at) !!}</td>
					<td>{{ $answer->user->name }}</td>
					<td>{{ optional($answer->discussion)->title }}</td>
					<td class="text-center">{!! Admin::status($answer->status) !!}</td>
					<td class="text-center">{!! Admin::action('edit', 'answers.edit', $answer->id) !!}</td>
					<td class="text-center">{!! Admin::action('delete', 'answers.destroy', $answer->id) !!}</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $answers->links() }}
			</div>
		@endif
	</div>

@endsection