@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<div class="pull-left">{!! Admin::back('home') !!}</div>
			{!! Admin::showMessage() !!}
		</div>
		@if(!$editionRequests->count())
			{!! Admin::createMessage($no_data['class'], $no_data['text']) !!}
		@else
			<table id="tabela" class="table table-striped table-hover">
				<thead>
					<tr>
						<th width="18%">{!! Admin::sort('updated_at', 'Data', 'Ordenar por data') !!}</th>
						<th width="18">{!! Admin::sort('model', 'Model', 'Ordenar por model') !!}</th>
						<th width="27%">Nome</th>
						<th width="27%">Usuário</th>
						<th width="10%" class="text-center" colspan="3">Ações</th>
					</tr>
				</thead>
				@foreach($editionRequests as $editionRequest)
				<tr>
					<td>{!! Admin::date($editionRequest->extensive_updated_at) !!}</td>
					<td>{{ $editionRequest->model_name }}</td>
					<td>
						<?php $className = 'App\\Admin\\Models\\' . $editionRequest->model_name; ?>
						{{ optional($className::find($editionRequest->entity_id))->name }}
					</td>
					<td>
					@if($editionRequest->user)
						{{ Str::words($editionRequest->user->name, 2) }} <em class="small">{{ $editionRequest->user->email }}</em>
					@endif
					</td>
					<td class="text-center">
						<a href="{{ route('editionRequests.view', $editionRequest->id) }}" title="Visualizar" rel="modal:open">
							<span class="glyphicon glyphicon-eye-open" alt="View"></span>
						</a>
					</td>
				</tr>
				@endforeach
			</table>
			<div id="paginacao">
				{{ $editionRequests->links() }}
			</div>
		@endif
	</div>

@endsection
