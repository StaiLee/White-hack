<x-app-layout>
  <header class="wh-container py-8">
    <div class="rounded-2xl border border-slate-800 bg-slate-900/40 p-6">
      <h1 class="text-2xl font-semibold">Bienvenue 👋</h1>
      <p class="wh-muted mt-2">Accède rapidement à tes cours et démarre un lab.</p>
      <div class="mt-4 flex gap-3">
        <a href="{{ route('courses.index') }}" class="wh-btn-primary">Voir les cours</a>
        <a href="{{ route('practice.index') }}" class="wh-btn-secondary">Accès pratique</a>
        <form method="POST" action="{{ route('logout') }}">
  @csrf
  <button type="submit" class="wh-btn-secondary">Se déconnecter</button>
</form>

      </div>
    </div>
  </header>

  <section class="wh-container pb-10">
    <h2 class="wh-section-title">Derniers cours</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      @forelse($courses as $course)
        <a href="{{ route('courses.show',$course->slug) }}" class="wh-card">
          <div class="mb-2 wh-chip">{{ ucfirst($course->level) }}</div>
          <h3 class="text-lg font-bold">{{ $course->title }}</h3>
          <p class="wh-muted mt-1 line-clamp-2">{{ $course->description }}</p>
          <div class="mt-4 text-slate-400 text-sm">{{ $course->duration_min }} min</div>
        </a>
      @empty
        <div class="wh-muted">Aucun cours publié pour l’instant.</div>
      @endforelse
    </div>
  </section>
</x-app-layout>
