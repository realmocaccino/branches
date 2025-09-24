<!doctype html>
<html lang="{{ config('site.locale') }}">
	<head>
		@include('site.layouts.main.head')
	</head>
	<body>
        <div class="container">
            {!! Alert::check() !!}
            <div class="row">
                <div class="col-12">
                    <div style="width: 207px; margin: 0 auto;">
                        @include('site.components.brand')
                    </div>
                </div>
            </div>
            <div class="row" id="error">
                <div class="col-12">
                    <img id="error-image" src="{{ asset('img/error/503.png') }}" alt="=/">
                    <p id="error-message">Estamos em uma breve manutenção</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="text-center descriptive" style="margin-top: 10px;">
                        <p>
                            @lang('layouts/main/footer.join_our_discord_server')
                        </p>
                        @component('site.components.social.discord', [
                            'size' => 'small'
                        ])
                        @endcomponent
                    </div>
                </div>
            </div>
        </div>
	</body>
</html>