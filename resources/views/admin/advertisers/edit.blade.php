@extends('admin.layouts.main.structure')

@section('content')

	<div class="container">
		<div id="info">
			<p>{!! Admin::back('advertisers.index') !!}</p>
		</div>
		{!! Form::model($advertiser, ['route' => ['advertisers.update', $advertiser->id], 'id' => 'formulario', 'class' => 'form-horizontal']) !!}
			@include('admin.advertisers.form')
		{!! Form::close() !!}
	</div>

@endsection
