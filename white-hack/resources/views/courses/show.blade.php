@extends('layouts.app')

@section('content')
<section class="card">
  <div class="section-head">
    <div>
      <p class="muted">Catalogue</p>
      <h1 class="rainbow-title animated-rainbow">Tous les cours</h1>
    </div>
    <form method="get" class="search-form" action="{{ route('courses.index') }}">
      <input class="inp" type="text" name="q" value="{{ $q ?? '' }}" placeholder="Rechercher un cours…">
      <button class="btn-secondary" type="submit">Rechercher</button>
    </form>
  </div>

  <div class="filters">
    @php $level = request('level'); @endphp
    <a class="btn-filter btn-rainbow {{ $level? '' : 'is-active' }}"
       href="{{ route('courses.index',['q'=>$q]) }}">Tous
       <span class="count">{{ ($total ?? null) ?: ($courses->total() ?? $courses->count()) }}</span>
    </a>
    <a class="btn-filter chip-easy chip-anim {{ $level==='debutant' ? 'is-active' : '' }}"
       href="{{ route('courses.index',['level'=>'debutant','q'=>$q]) }}">Facile
       <span class="count">{{ $counts['debutant'] ?? '' }}</span>
    </a>
    <a class="btn-filter chip-medium chip-anim {{ $level==='intermediaire' ? 'is-active' : '' }}"
       href="{{ route('courses.index',['level'=>'intermediaire','q'=>$q]) }}">Moyen
       <span class="count">{{ $counts['intermediaire'] ?? '' }}</span>
    </a>
    <a class="btn-filter chip-hard chip-anim {{ $level==='avance' ? 'is-active' : '' }}"
       href="{{ route('courses.index',['level'=>'avance','q'=>$q]) }}">Difficile
       <span class="count">{{ $counts['avance'] ?? '' }}</span>
    </a>
  </div>
</section>

<section class="grid-2 mt-4">
  @forelse($courses as $c)
    @php
      $lvl = strtolower($c->level ?? 'debutant');
      $tClass = $lvl === 'debutant' ? 't-easy' : ($lvl === 'intermediaire' ? 't-medium' : 't-hard');
      $chip = $lvl === 'debutant' ? 'chip-easy' : ($lvl === 'intermediaire' ? 'chip-medium' : 'chip-hard');
    @endphp
    <article class="course-card">
      <div class="course-card__bg"></div>
      <span class="course-card__badge {{ $chip }} chip-anim">{{ ucfirst($lvl) }} • ~{{ $c->duration_min ?? 120 }} min</span>
      <h3 class="course-card__title {{ $tClass }}">{{ $c->title }}</h3>
      <p class="course-card__desc">{{ $c->description }}</p>
      <div class="course-card__hover"></div>
      <a href="{{ route('courses.show',$c->slug) }}" class="btn-ghost mt-2">Ouvrir le cours →</a>
    </article>
  @empty
    <div class="wh-card">Aucun cours pour le moment.</div>
  @endforelse
</section>

<div class="mt-5">
  {{ $courses->withQueryString()->links() }}
</div>
@endsection
