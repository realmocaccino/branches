@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('home') !!}</p>
			@if(session()->has('message'))
				{!! Admin::showMessage() !!}
			@else
				{!! Admin::createMessage('info', 'Última atualização em '.$settings->extensive_updated_at) !!}
			@endif
		</div>
		{!! Form::model($settings, ['route' => 'settings.update', 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			{!! Form::text('url', ['label' => 'URL', 'placeholder' => 'Digite a url do site']) !!}
			{!! Form::text('name', ['label' => 'Nome', 'placeholder' => 'Digite o nome do site']) !!}
			{!! Form::text('description_pt', ['label' => 'Descrição', 'placeholder' => 'Redija uma descrição para o site']) !!}
			{!! Form::text('description_en', ['label' => 'Description', 'placeholder' => 'Write a description for the website']) !!}
			{!! Form::text('description_es', ['label' => 'Descripción', 'placeholder' => 'Escribe una descripción para el sitio web']) !!}
			{!! Form::text('description_fr', ['label' => 'Description', 'placeholder' => 'Rédiger une description pour le site web']) !!}
			{!! Form::text('email', ['label' => 'Email', 'placeholder' => 'Digite o email de contato']) !!}
			{!! Form::textarea('analytics', ['label' => 'Google Analytics', 'placeholder' => 'Insira o código de verificação do Google', 'rows' => 2]) !!}
			{!! Form::checkbox('robots', 1, ['label' => 'Permitir indexação das páginas do site por mecanismos de busca']) !!}
			{!! Form::checkbox('advertisements', 1, ['label' => 'Permitir que anúncios sejam exibidos nas páginas do site']) !!}
			{!! Form::submit('Atualizar', ['class' => 'btn-success']) !!}
		{!! Form::close() !!}
	</div>

@endsection
