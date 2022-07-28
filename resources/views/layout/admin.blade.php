<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>@yield('title') {{ ts() }} {{ settings('admin.meta.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
</head>
<body>
<main role="main" class="d-flex flex-column">
    <div id="bars">
        @component('components.navbar') @endcomponent
        @component('components.sidebar') @endcomponent
    </div>
    <div id="content" class="d-flex flex-column flex-fill">
        @if(request()->route()->getName() != 'home')
        <nav id="breadcrumb" aria-label="breadcrumb" class="fw-semibold">@yield('breadcrumb')</nav>
        @endif
        <div id="module" class="d-flex flex-column flex-fill">@yield('content')</div>
    </div>
</main>
<script src="{{ asset('/js/manifest.js') }}"></script>
<script src="{{ asset('/js/vendor.js') }}"></script>
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ route('system.settings.list') }}"></script>
@yield('javascript')
</body>
</html>
