<x-app-layout>
  <section class="wh-container py-8">
    <div class="mb-6 flex items-center justify-between">
      <div>
        <a href="{{ route('courses.show', $lesson->module->course->slug) }}" class="text-slate-400 hover:text-slate-200">&larr; Retour au cours</a>
        <h1 class="mt-2 text-2xl font-semibold">{{ $lesson->title }}</h1>
        <p class="wh-muted text-sm">Cours : {{ $lesson->module->course->title }} • Module : {{ $lesson->module->title }}</p>
      </div>
      <div class="flex gap-2">
        @if($prev)
          <a href="{{ route('lessons.show', $prev) }}" class="wh-btn-secondary">← Précédent</a>
        @endif
        @if($next)
          <a href="{{ route('lessons.show', $next) }}" class="wh-btn-primary">Suivant →</a>
        @endif
      </div>
    </div>

    <article class="prose prose-invert max-w-none">
      {!! $html !!}
    </article>

    <p class="mt-8 text-xs text-slate-500">
      ⚠️ Utilisation uniquement en environnement de test / lab autorisé. Respect du cadre légal & éthique.
    </p>
  </section>
</x-app-layout>
