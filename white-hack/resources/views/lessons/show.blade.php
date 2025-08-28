@extends('layouts.app')

@section('content')
<article class="card">
  <p class="muted up">Leçon</p>
  <h1 class="lesson-title rainbow-title animated-rainbow"> {{ $lesson->title }} </h1>

  <div class="lesson-body">
    {!! $html ?? nl2br(e($lesson->markdown)) !!}
  </div>

  <div class="lesson-nav mt-5">
    @if($prev ?? null)
      <a class="btn-ghost" href="{{ route('lessons.show',$prev) }}">← {{ $prev->title }}</a>
    @endif
    <div class="flex-1"></div>
    @if($next ?? null)
      <a class="btn-primary" href="{{ route('lessons.show',$next) }}">{{ $next->title }} →</a>
    @endif
  </div>
</article>
@endsection
