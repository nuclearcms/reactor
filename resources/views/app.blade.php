<!doctype html>
<html lang="{{ str_replace('_', '-', $user->locale) }}" class="no-js">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name') }}</title>

	<!-- Styles -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" integrity="sha256-+N4/V/SbAFiW1MPBCXnfnP9QSN3+Keu+NlB+0ev/YKQ=" crossorigin="anonymous" />
	<link href="{{ asset('vendor/app/css/app.css') }}" rel="stylesheet">
	@stack('styles')

	<!-- Scripts -->
	<script src="{{ route('utilities.translations', $user->locale) }}" defer></script>
	<script>
		window.locale = '{{ $user->locale }}'
		window.app_locale = '{{ config('app.locale') }}'
		window.app_locales = {!! json_encode(config('app.locales')) !!}
		window.token = '{{ $user->api_token }}'
		window.nuclear_version = '{{ nuclear_version() }}'
		window.allowed_extensions = {!! json_encode(allowed_extensions()) !!}
		window.allowed_mimetypes = {!! json_encode(allowed_mimetypes()) !!}
		window.allowed_size = {{ max_upload_size() }}
		window.permissions = {!! json_encode($user->all_permissions) !!}
		window.home_content = {{ config('app.home_content') }}
	</script>
	<script src="{{ asset('vendor/app/js/app.js') }}" defer></script>
</head>
<body>
	<div id="app"></div>
	<form id="logout-form" action="{{ route('reactor.logout') }}" method="POST" class="is-display-none">
		@csrf
	</form>
</body>
</html>
