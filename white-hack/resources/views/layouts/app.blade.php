<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'WhiteHack' }}</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-950 text-slate-100 antialiased">
    <!-- Background gradient -->
    <div aria-hidden="true" class="pointer-events-none fixed inset-0 bg-[radial-gradient(60rem_30rem_at_50%_-10%,rgba(34,211,238,0.08),transparent),radial-gradient(50rem_25rem_at_80%_10%,rgba(16,185,129,0.06),transparent)]"></div>

    @include('layouts.navigation')

    <!-- Page Content -->
    <main class="relative z-0">
        {{ $slot }}
    </main>
</body>
</html>
