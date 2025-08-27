{{-- Catalogue des cours --}}
<x-app-layout>
  <section class="wh-container py-10">
    <header class="mb-8">
      <h1 class="text-3xl font-semibold">Catalogue des cours</h1>
      <p class="wh-muted mt-1">Parcours structurés, labs balisés. Choisis et lance-toi.</p>
      <form method="get" class="mt-6">
        <div class="relative max-w-md">
          <input type="search" name="q" value="{{ $q }}" placeholder="Rechercher un cours…"
                 class="w-full rounded-2xl bg-slate-900/70 border border-slate-800 px-4 py-3 text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
          <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-500">Entrée ↵</span>
        </div>
      </form>
    </header>

    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
      @forelse($courses as $course)
        <a href="{{ route('courses.show',$course->slug) }}"
           class="group relative overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60 p-6 transition hover:border-slate-700 hover:bg-slate-900">
          <div class="pointer-events-none absolute -right-16 -top-16 h-40 w-40 rounded-full bg-emerald-500/10 blur-2xl"></div>
          <div class="mb-2 inline-flex items-center gap-2">
            <span class="wh-chip">{{ ucfirst($course->level) }}</span>
            <span class="wh-chip">{{ $course->duration_min }} min</span>
          </div>
          <h2 class="mt-1 text-xl font-semibold group-hover:underline">{{ $course->title }}</h2>
          <p class="wh-muted mt-2 line-clamp-2">{{ $course->description }}</p>
          <div class="mt-6 text-sm text-slate-400">Ouvrir le cours →</div>
        </a>
      @empty
        <div class="wh-muted">Aucun cours publié.</div>
      @endforelse
    </div>

    <div class="mt-8">{{ $courses->links() }}</div>
  </section>
</x-app-layout>
