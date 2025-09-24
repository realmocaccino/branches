@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('contacts.index') !!}</p>
		</div>
		{!! Form::model($contact, ['route' => ['contacts.update', $contact->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.contacts.form')
		{!! Form::close() !!}
	</div>

@endsection
