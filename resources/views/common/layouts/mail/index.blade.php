<html>
	<head>
		<style>
			body {
				margin: 0;
				padding: 0;
				font-family: Verdana;
				background-color: #E9EBEE;
				color: #2A2A2A;
			}
			
			a {
				text-decoration: none;
				color: #2A2A2A;
				font-weight: bold;
			}
		
			table#wrapper {
				width: 600px;
				margin: 0 auto;
				text-align: left;
			}
			
			table#wrapper tr#header {}
			
			table#wrapper tr#header td {}
			
			table#wrapper tr#header td a {
				margin: 0;
				font-weight: bold;
				font-size: 30px;
				text-align: left;
			}
			
			table#wrapper tr#header td a img {
				width: 96px;
			}
			
			table#wrapper tr#content {
				background-color: #FFF;
				font-size: 16px;
			}
			
			table#wrapper tr#content td {
				border-radius: 8px;
			}
			
			table#wrapper tr#footer {
				text-align: center;
			}
			
			table#wrapper tr#footer td {
				padding-top: 100px;
				font-size: 12px;
			}
		</style>
	</head>
	<body>
		<table id="wrapper">
			<tr id="header">
				<td>
					<a href="{{ route('home') }}">
						<img src="{{ asset('img/logo.png') }}" alt="{{ $settings->name }}">
					</a>
				</td>
			</tr>
			<tr id="content">
				<td>
					@yield('content')
				</td>
			</tr>
			<tr id="footer">
				<td>
				    @if(isset($user) and Route::has('mail.unsubscribe'))
				        <p><a href="{{ route('mail.unsubscribe', $user->email) }}">Clique aqui</a> para se desinscrever de nossa newsletter</p>
				    @endif
					<p>&copy; {{ date('Y') }} notadogame.com</p>
					<p>
						@component('site.components.social.mail')
						@endcomponent
					</p>
				</td>
			</tr>
		</table>
	</body>
</html>