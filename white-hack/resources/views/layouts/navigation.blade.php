<nav class="sticky top-0 z-50 backdrop-blur bg-slate-950/60 border-b border-slate-800">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 items-center justify-between">
      <!-- Logo + Brand -->
      <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
        <x-application-logo />
        <span class="font-semibold tracking-wide">WhiteHack</span>
      </a>

      <!-- Links -->
      <div class="hidden md:flex items-center gap-2">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
        <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">Cours</x-nav-link>
        <x-nav-link :href="route('practice.index')" :active="request()->routeIs('practice.*')">Pratique</x-nav-link>
      </div>

      <!-- Profil -->
      <div class="flex items-center gap-3">
        @auth
          <a href="{{ route('profile.edit') }}" class="hidden sm:inline-block rounded-xl border border-slate-800 bg-slate-900/60 px-3 py-1.5 text-sm hover:bg-slate-900">
            Profil
          </a>
        @endauth
      </div>
    </div>
  </div>
</nav>
