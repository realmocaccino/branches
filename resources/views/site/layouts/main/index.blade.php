<!doctype html>
<html lang="{{ config('site.locale') }}">
	<head>
		@include('site.layouts.main.head')
	</head>
	<body class="dark @if($isHeaderStatic) header-static @endif">
		<div id="wrapper">
			<div id="header">
			    {!! Alert::check() !!}
				<div class="container-fluid">
					@include('site.layouts.main.header')
				</div>
			</div>
			@hasSection('content-header')
				<div id="content-header">
					@yield('content-header')
				</div>
			@endif
			<div id="content" @if($isGamePage) class="noBorder" @endif>
				<div class="container-fluid">
					@yield('content')
				</div>
			</div>
			<div id="footer">
				<div class="container-fluid">
					@include('site.layouts.main.footer')
				</div>
			</div>
		</div>
		<div id="wrapper-overlay" class="overlay"></div>
		@include('site.layouts.main.sides')
		@include('site.layouts.main.foot')
	</body>
</html>