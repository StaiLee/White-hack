{{-- resources/views/courses/index.blade.php --}}
<x-app-layout>
  @php
    $active = request('level'); // '', 'easy', 'mid', 'hard'
    $map = ['easy'=>'debutant','mid'=>'intermediaire','hard'=>'avance'];

    // Stats pour les filtres
    $countAll  = \App\Models\Course::where('is_published',true)->count();
    $countEasy = \App\Models\Course::where('is_published',true)->where('level','debutant')->count();
    $countMid  = \App\Models\Course::where('is_published',true)->where('level','intermediaire')->count();
    $countHard = \App\Models\Course::where('is_published',true)->where('level','avance')->count();

    // Liste des cours paginés (avec filtre si présent)
    $courses = \App\Models\Course::where('is_published',true)
      ->when($active, function($q) use($map,$active){
        if(isset($map[$active])) $q->where('level', $map[$active]);
      })
      ->orderByDesc('created_at')
      ->paginate(12)
      ->withQueryString();
  @endphp

  <section class="wh-container">
    <div class="card">
      <div class="section-head">
        <div>
          <p class="muted up mb-2">Catalogue</p>
          <h1 class="rainbow-title animated-rainbow" style="font-size:2.4rem;margin:0">Tous les cours</h1>

          <div class="filters mt-3">
            <a class="btn-filter btn-rainbow {{ $active==='' ? 'is-active':'' }}" href="{{ route('courses.index') }}">
              Tous <span class="count">{{ $countAll }}</span>
            </a>
            <a class="btn-filter chip-easy {{ $active==='easy' ? 'is-active':'' }}" href="{{ route('courses.index',['level'=>'easy']) }}">
              Facile <span class="count">{{ $countEasy }}</span>
            </a>
            <a class="btn-filter chip-medium {{ $active==='mid' ? 'is-active':'' }}" href="{{ route('courses.index',['level'=>'mid']) }}">
              Moyen <span class="count">{{ $countMid }}</span>
            </a>
            <a class="btn-filter chip-hard {{ $active==='hard' ? 'is-active':'' }}" href="{{ route('courses.index',['level'=>'hard']) }}">
              Difficile <span class="count">{{ $countHard }}</span>
            </a>
          </div>
        </div>

        <form method="get" class="search-form">
          <input class="inp" type="text" name="q" value="{{ request('q') }}" placeholder="Rechercher un cours…">
          @if($active) <input type="hidden" name="level" value="{{ $active }}"> @endif
          <button class="btn-secondary">Rechercher</button>
        </form>
      </div>
    </div>

    <div class="courses-grid mt-5">
      @foreach($courses as $c)
        <article class="course-card">
          <div class="course-card__bg"></div>
          <div class="course-card__hover"></div>

          <div class="course-card__badge {{ $c->level==='debutant' ? 'chip-easy' : ($c->level==='intermediaire' ? 'chip-medium' : 'chip-hard') }}">
            {{ ucfirst($c->level) }} • ~{{ $c->duration_min }} min
          </div>

          <h3 class="course-card__title
            {{ $c->level==='debutant' ? 't-easy' : ($c->level==='intermediaire' ? 't-medium' : 't-hard') }}">
            {{ $c->title }}
          </h3>

          <p class="course-card__desc">
            {{ $c->description }}
          </p>

          <div class="course-card__footer">
            <a href="{{ route('courses.show',$c->slug) }}" class="btn-primary">Ouvrir le cours →</a>
          </div>
        </article>
      @endforeach
    </div>

    {{-- Pagination stylée --}}
    <div class="pagination">
      {{ $courses->onEachSide(1)->links() }}
    </div>
  </section>
</x-app-layout>
