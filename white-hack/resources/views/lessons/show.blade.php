{{-- resources/views/lessons/show.blade.php --}}
<x-app-layout>
  @php
    /** @var \App\Models\Lesson $lesson */
    $module = $lesson->module;
    $course = $module?->course;

    $level = $course?->level ?? 'debutant';
    $chip = $level === 'debutant' ? 'chip-easy' : ($level === 'intermediaire' ? 'chip-medium' : 'chip-hard');
    $tone = $level === 'debutant' ? 't-easy'   : ($level === 'intermediaire' ? 't-medium' : 't-hard');

    // Prev / Next dans le module courant
    $siblings = $module?->lessons()->orderBy('order')->get() ?? collect();
    $idx = max(0, $siblings->search(fn($l) => $l->id === $lesson->id));
    $prev = $idx > 0 ? $siblings[$idx-1] : null;
    $next = $idx < $siblings->count()-1 ? $siblings[$idx+1] : null;
  @endphp

  <section class="wh-container">
    {{-- En-tête --}}
    <div class="card">
      <p class="muted up mb-2">LEÇON</p>
      <h1 class="course-card__title {{ $tone }}" style="margin:0">{{ $lesson->title }}</h1>
      @if($course)
        <p class="muted" style="margin:.5rem 0 0">
          Dans le cours <a class="link-soft" href="{{ route('courses.show', $course->slug) }}">{{ $course->title }}</a>
        </p>
        <div style="margin-top:1rem;display:flex;gap:10px;flex-wrap:wrap">
          <span class="btn-filter {{ $chip }}">{{ ucfirst($course->level) }} • ~{{ $course->duration_min }} min</span>
          <a class="btn-ghost" href="{{ route('courses.show', $course->slug) }}">← Retour au cours</a>
          <a class="btn-ghost" href="{{ route('courses.index') }}">Tous les cours</a>
        </div>
      @endif
    </div>

   {{-- Corps de leçon + navigation --}}
<div class="lesson-cols mt-4">
  <article class="wh-card lesson-body md">
    {!! \Illuminate\Support\Str::markdown($lesson->markdown ?? '') !!}
  </article>

  <aside class="wh-card">
    <p class="up muted">Navigation</p>
    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:.5rem">
      @if($prev)
        <a class="btn-secondary" href="{{ route('lessons.show', ['lesson'=>$prev->id]) }}">← {{ $prev->title }}</a>
      @endif
      @if($next)
        <a class="btn-primary" href="{{ route('lessons.show', ['lesson'=>$next->id]) }}">{{ $next->title }} →</a>
      @endif
    </div>

    @if($siblings->count())
      <div class="mt-3">
        <p class="up muted">Dans ce module</p>
        <ul class="road-lessons">
          @foreach($siblings as $s)
            <li>
              <a class="road-link {{ $s->id === $lesson->id ? 'is-active' : '' }}"
                 href="{{ route('lessons.show', ['lesson'=>$s->id]) }}">
                {{ $s->title }}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    @endif
  </aside>
</div>
  </section>
</x-app-layout>
