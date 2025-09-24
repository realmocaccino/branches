<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="none">
<meta name="csrf_token" content="{{ csrf_token() }}">
<title>{{ $head->getFullTitle($settings->name) }}</title>
<!-- Styles -->
<link href="{{ url('css/estrutura.css') }}" rel="stylesheet">
<link href="{{ url('css/bootstrap.css') }}" rel="stylesheet">
<link href="{{ url('css/sweetalert.min.css') }}" rel="stylesheet">
<link href="{{ url('css/modal.min.css') }}" rel="stylesheet">
<link href="{{ url('css/form/bootstrap-switch.css') }}" rel="stylesheet">
<link href="{{ url('css/form/select2.css') }}" rel="stylesheet">
<link href="{{ url('css/form/icheck-flat-blue.css') }}" rel="stylesheet">
<link href="{{ url('css/form/jodit.min.css') }}" rel="stylesheet">
<link href="{{ url('css/form/bootstrap-fileinput.css') }}" rel="stylesheet">
@if($head->getStyles())
	@foreach($head->getStyles() as $style)
		<link href="{{ $style }}" rel="stylesheet">
	@endforeach
@endif
<!-- Scripts -->
<script src="{{ url('js/jquery.min.js') }}"></script>
<script src="{{ url('js/sweetalert.min.js') }}"></script>
<script src="{{ url('js/modal.min.js') }}"></script>
<script src="{{ url('js/form/bootstrap-switch.min.js') }}"></script>
<script src="{{ url('js/form/select2.min.js') }}"></script>
<script src="{{ url('js/form/icheck.min.js') }}"></script>
<script src="{{ url('js/form/jodit.min.js') }}"></script>
<script src="{{ url('js/form/bootstrap-fileinput.min.js') }}"></script>
<script src="{{ url('js/form/maskit.min.js') }}"></script>
@if($head->getScripts())
	@foreach($head->getScripts() as $script)
		<script src="{{ $script }}"></script>
	@endforeach
@endif
<script src="{{ url('js/global.js') }}"></script>
