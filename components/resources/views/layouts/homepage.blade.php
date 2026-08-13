<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ localization()->getCurrentLocaleDirection() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="{{ asset('assets/img/favicon.svg') }}">
  {!! SEO::generate() !!}
  <link rel="stylesheet" href="{{ asset('assets/css/google-fonts-local.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/homepage.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/homepage.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/homepage-nav.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/homepage-nav.css') ?: '1' }}">
  <link rel="stylesheet" href="{{ asset('assets/css/default-footer.css') }}?v={{ @filemtime(dirname(base_path()).'/assets/css/default-footer.css') ?: '1' }}">
  <style>:root{--serif:"Urbanist",ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;--sans:"Outfit",ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}body,p{font-family:var(--sans)}</style>
  @livewireStyles
</head>
<body class="fxn-home">
  {{ $slot }}
  <x-public.footer :footer="$footer" :general="$general" :socials="$socials" />
  @livewireScripts
</body>
</html>
