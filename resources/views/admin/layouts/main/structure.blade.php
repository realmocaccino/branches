<!doctype html>
<html>
	<head>
		@include('admin.layouts.main.head')
	</head>
	<body>
		<div id="corpo">
			@include('admin.layouts.main.header')
			@yield('content')
		</div>
		@include('admin.layouts.main.footer')
	</body>
</html>
