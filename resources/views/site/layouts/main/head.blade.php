		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="@if($currentRouteName == 'home')@lang('layouts/main/head.home_description')@else{{ $head->getDescription() }}@endif">
		<meta name="csrf_token" content="{{ csrf_token() }}">
@if($head->isSearchIndexingDisabled())
		<meta name="robots" content="none">
@endif
		<meta property="og:site_name" content="{{ $settings->name }}">
		<meta property="og:url" content="{{ url()->current() }}">
		<meta property="og:type" content="game">
		<meta property="og:title" content="<?php echo $head->getTitle(true) ?: $settings->name ?>">
		<meta property="og:description" content="@if($currentRouteName == 'home')@lang('layouts/main/head.home_description')@else{{ $head->getDescription() }}@endif">
@if($head->getImage())
		<meta property="og:image" content="{{ $head->getImage()->url }}">
		<meta property="og:image:width" content="{{ $head->getImage()->width }}">
		<meta property="og:image:height" content="{{ $head->getImage()->height }}">
@endif
@if($head->getFacebookId())
		<meta property="fb:app_id" content="{{ $head->getFacebookId() }}">
@endif
		<meta name="theme-color" content="#FF3E3E">
		<title>{{ $head->getFullTitle(true) }}</title>
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/open-iconic/1.1.1/font/css/open-iconic-bootstrap.min.css" rel="stylesheet">
@if($head->getStyles())
	@foreach($head->getStyles() as $style)
		<link href="{{ $style }}" rel="stylesheet">
	@endforeach
@endif
		<link href="{{ asset(Site::getCompiledFilename('css')) }}" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;700&display=swap" rel="stylesheet">
		<link rel="manifest" href="manifest.json">
@if(Site::canShowAd())
		<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4116067897176342" crossorigin="anonymous"></script>
@else
		<style>
			.google-auto-placed {
				display: none;
			}
		</style>
@endif