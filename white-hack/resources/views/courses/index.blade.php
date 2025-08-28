{{-- resources/views/courses/index.blade.php --}}
<x-app-layout>
  @php
    $active = request('level'); // '', 'easy', 'mid', 'hard'

    $countAll  = \App\Models\Course::where('is_published',true)->count();
    $countEasy = \App\Models\Course::where('is_published',true)->where('level','debutant')->count();
    $countMid  = \App\Models\Course::where('is_published',true)->where('level','intermediaire')->count();
    $countHard = \App\Models\Course::where('is_published',true)->where('level','avance')->count();
  @endphp

  <section class="wh-container">
    <div class="card">
      {{-- Conteneur grid: gauche = titre+filtres, droite = search --}}
      <div class="section-head course-head">
        <div class="head-left">
          <p class="muted up mb-2">Catalogue</p>
          <h1 class="rainbow-title animated-rainbow" style="margin:0">Tous les cours</h1>

          <div class="filters mt-3">
            <a href="{{ route('courses.index') }}"
               class="btn-filter btn-rainbow {{ $active==='' ? 'is-active' : '' }}">
              Tous <span class="count">{{ $countAll }}</span>
            </a>

            <a href="{{ route('courses.index', ['level'=>'easy']) }}"
               class="btn-filter pill-easy {{ $active==='easy' ? 'is-active' : '' }}">
              Facile <span class="count">{{ $countEasy }}</span>
            </a>

            <a href="{{ route('courses.index', ['level'=>'mid']) }}"
               class="btn-filter pill-mid {{ $active==='mid' ? 'is-active' : '' }}">
              Moyen <span class="count">{{ $countMid }}</span>
            </a>

            <a href="{{ route('courses.index', ['level'=>'hard']) }}"
               class="btn-filter pill-hard {{ $active==='hard' ? 'is-active' : '' }}">
              Difficile <span class="count">{{ $countHard }}</span>
            </a>
          </div>
        </div>

        {{-- Search à DROITE --}}
        <form class="search-form course-search" method="get" action="{{ route('courses.index') }}">
          <input class="inp" type="search" name="q" placeholder="Rechercher un cours…" value="{{ request('q') }}">
          <button class="btn-secondary" type="submit">Rechercher</button>
        </form>
      </div>
    </div>

    <div class="courses-grid mt-4">
      @foreach($courses as $c)
        @php
          $tone = $c->level === 'debutant' ? 't-easy' : ($c->level === 'intermediaire' ? 't-medium' : 't-hard');
          $chip = $c->level === 'debutant' ? 'chip-easy' : ($c->level === 'intermediaire' ? 'chip-medium' : 'chip-hard');
        @endphp

        <article class="course-card">
          <div class="course-card__bg"></div>
          <div class="course-card__hover"></div>

          <div class="course-card__badge {{ $chip }}">
            {{ ucfirst($c->level) }} • ~{{ $c->duration_min }} min
          </div>

          <h3 class="course-card__title {{ $tone }}">{{ $c->title }}</h3>
          <p class="course-card__desc">{{ $c->description }}</p>

          <div class="course-card__footer">
            <a href="{{ route('courses.show',$c->slug) }}" class="btn-primary">Ouvrir le cours →</a>
          </div>
        </article>
      @endforeach
    </div>

    @if(method_exists($courses,'links'))
      <div class="pagination mt-4">
        {{ $courses->links() }}
      </div>
    @endif
  </section>
</x-app-layout>
