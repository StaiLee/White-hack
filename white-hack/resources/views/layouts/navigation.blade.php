{{-- resources/views/layouts/navigation.blade.php --}}
<nav class="wh-nav">
  <div class="wh-container nav-inner">
    <a href="{{ route('dashboard') }}" class="brand">
      <span class="logo-dot"></span>
      <span class="brand-text">WhiteHack</span>
    </a>

    <ul class="nav-links">
      <li><a href="{{ route('courses.index') }}">Cours</a></li>
      <li><a href="{{ route('practice.index') }}">Pratique</a></li>
    </ul>

    <div class="nav-actions">
      @auth
        <form method="POST" action="{{ route('logout') }}">@csrf
          <button class="btn-secondary">Se déconnecter</button>
        </form>
      @else
        <a class="btn-ghost" href="{{ route('login') }}">Login</a>
        <a class="btn-primary" href="{{ route('register') }}">Register</a>
      @endauth
    </div>
  </div>
</nav>
