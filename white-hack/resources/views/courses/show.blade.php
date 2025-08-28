{{-- resources/views/courses/show.blade.php --}}
<x-app-layout>
  @php
    $chip = fn($lvl) => $lvl==='debutant' ? 'chip-easy' : ($lvl==='intermediaire' ? 'chip-medium' : 'chip-hard');
    $tone = fn($lvl) => $lvl==='debutant' ? 't-easy' : ($lvl==='intermediaire' ? 't-medium' : 't-hard');
    $filterParam = $course->level === 'debutant' ? 'easy' : ($course->level === 'intermediaire' ? 'mid' : 'hard');
  @endphp

  <section class="wh-container">
    <div class="card">
      <p class="muted up mb-2">COURS</p>
      <h1 class="course-card__title {{ $tone($course->level) }}" style="margin:0">
        {{ $course->title }}
      </h1>
      <p class="muted" style="max-width:70ch;margin-top:.5rem">{{ $course->description }}</p>

      <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:1rem">
        <span class="btn-filter {{ $chip($course->level) }}">{{ ucfirst($course->level) }} • ~{{ $course->duration_min }} min</span>
        <a class="btn-secondary" href="{{ route('courses.index',['level'=>$filterParam]) }}">→ Voir les cours {{ $course->level === 'debutant' ? 'faciles' : ($course->level === 'intermediaire' ? 'moyens' : 'difficiles') }}</a>
      </div>
    </div>

    @if($course->modules->count())
      <div class="grid-2 mt-4">
        @foreach($course->modules as $module)
          <article class="wh-card">
            <p class="up muted" style="margin:0 0 .6rem"> {{ $module->title }} </p>

            @if($module->lessons->count())
              <ul class="road-lessons">
                @foreach($module->lessons as $lesson)
                  <li>
                    <a class="road-link" href="{{ route('lessons.show', ['lesson'=>$lesson->id]) }}">
                      {{ $lesson->title }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @else
              <p class="muted">Aucune leçon pour le moment.</p>
            @endif
          </article>
        @endforeach
      </div>
    @endif

    <div class="mt-3">
      <a class="btn-ghost" href="{{ route('courses.index') }}">← Tous les cours</a>
    </div>
  </section>
</x-app-layout>
