{{-- resources/views/components/app-layout.blade.php --}}
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'WhiteHack' }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="wh-body">
  @include('layouts.navigation')

  <main>
    {{ $slot }}
  </main>
</body>
</html>
