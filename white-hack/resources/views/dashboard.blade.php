{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
  @php
    $latest = \App\Models\Course::where('is_published', true)
      ->orderByDesc('created_at')->take(6)->get();

    $easyCount = \App\Models\Course::where('is_published',true)->where('level','debutant')->count();
    $midCount  = \App\Models\Course::where('is_published',true)->where('level','intermediaire')->count();
    $hardCount = \App\Models\Course::where('is_published',true)->where('level','avance')->count();
    $totalCount = $easyCount + $midCount + $hardCount;

    $lessonsCount = \App\Models\Lesson::count();

    $targetCount = 0;
    try {
      if (\Illuminate\Support\Facades\Schema::hasTable('targets')) {
        $targetCount = \Illuminate\Support\Facades\DB::table('targets')->count();
      }
    } catch (\Throwable $e) { $targetCount = 0; }

    $chip = fn($lvl) => $lvl==='debutant' ? 'chip-easy' : ($lvl==='intermediaire' ? 'chip-medium' : 'chip-hard');
    $tone = fn($lvl) => $lvl==='debutant' ? 't-easy' : ($lvl==='intermediaire' ? 't-medium' : 't-hard');
  @endphp

  <section class="wh-container">
    <div class="card hero">
      <p class="muted up mb-2">Dashboard</p>
      <h1 class="hero-title">
        <span class="rainbow-title animated-rainbow" style="font-size:2.2rem">Bienvenue sur WhiteHack</span>
      </h1>
      <p class="hero-sub">Reprends ta progression, lance une pratique, ou explore de nouveaux cours.</p>
      <div class="hero-cta">
        <a class="btn-primary" href="{{ route('courses.index') }}">Parcourir les cours →</a>
        <a class="btn-secondary" href="{{ route('practice.index') }}">Pratique</a>
      </div>
    </div>

    <div class="grid-3 mt-5">
      <div class="wh-card">
        <p class="muted">Leçons</p>
        <div class="stat-big">{{ $lessonsCount }}</div>
        <div class="progress-wrap"><div class="progress-bar" style="--p: 24%"></div></div>
      </div>

      <div class="wh-card">
        <p class="muted">Cibles de pratique</p>
        <div class="stat-big">{{ $targetCount }}</div>
        <div class="progress-wrap"><div class="progress-bar" style="--p: 18%"></div></div>
      </div>

      <div class="wh-card">
        <p class="muted">Répartition des niveaux</p>
        <div class="mt-3" style="display:flex;gap:10px;flex-wrap:wrap">
          <a href="{{ route('courses.index') }}" class="btn-filter btn-rainbow">Tous <span class="count">{{ $totalCount }}</span></a>
          <a href="{{ route('courses.index', ['level' => 'easy']) }}" class="btn-filter chip-easy">Facile <span class="count">{{ $easyCount }}</span></a>
          <a href="{{ route('courses.index', ['level' => 'mid'])  }}" class="btn-filter chip-medium">Moyen <span class="count">{{ $midCount }}</span></a>
          <a href="{{ route('courses.index', ['level' => 'hard']) }}" class="btn-filter chip-hard">Difficile <span class="count">{{ $hardCount }}</span></a>
        </div>
      </div>
    </div>

    <div class="mt-6">
      <div class="section-head">
        <h2 class="rainbow-title animated-rainbow" style="font-size:1.6rem;margin:0">Nouveaux cours</h2>
        <a class="btn-ghost" href="{{ route('courses.index') }}">Tous les cours →</a>
      </div>

      <div class="courses-grid mt-4">
        @foreach($latest as $c)
          <article class="course-card">
            <div class="course-card__bg"></div>
            <div class="course-card__hover"></div>

            <div class="course-card__badge {{ $chip($c->level) }}">
              {{ ucfirst($c->level) }} • ~{{ $c->duration_min }} min
            </div>

            <h3 class="course-card__title {{ $tone($c->level) }}">{{ $c->title }}</h3>
            <p class="course-card__desc">{{ $c->description }}</p>

            <div class="course-card__footer">
              <a href="{{ route('courses.show',$c->slug) }}" class="btn-primary">Ouvrir le cours →</a>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>
</x-app-layout>
