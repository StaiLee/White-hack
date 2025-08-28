{{-- resources/views/practice/index.blade.php --}}
<x-app-layout>
  <section class="wh-container">
    <div class="card hero">
      <p class="muted up mb-2">Pratique</p>
      <h1 class="hero-title">
        <span class="rainbow-title animated-rainbow" style="font-size:2.0rem">Connexion & Labs</span>
      </h1>
      <p class="hero-sub">Lance une machine d'entraînement et expérimente en toute sécurité.</p>
    </div>

    <div class="grid-2 mt-5">
      @forelse($targets as $t)
        <article class="course-card">
          <div class="course-card__bg"></div>
          <div class="course-card__hover"></div>

          <div class="course-card__badge chip-medium">
            {{ strtoupper($t->protocol) }} • {{ $t->host }}:{{ $t->port }}
          </div>

          <h3 class="course-card__title t-medium">{{ $t->name }}</h3>
          <p class="course-card__desc">{{ $t->description }}</p>

          <div class="course-card__footer">
            <a href="http://192.168.230.140:6080/vnc.html?autoconnect=true&password=WhiteHack%212025&resize=scale&autofit=1"
               target="_blank" rel="noopener" class="btn-primary">
              Connexion GUI (VM) →
            </a>
          </div>
        </article>
      @empty
        <div class="wh-card">
          <p class="muted">Aucune cible disponible pour le moment.</p>
        </div>
      @endforelse
    </div>
  </section>
</x-app-layout>
