{{-- resources/views/practice/index.blade.php --}}
<x-app-layout>
  <section class="wh-container py-8">
    <h1 class="text-2xl font-semibold mb-4">Pratique (Labs)</h1>

    @if (session('status'))
      <div class="mb-4 rounded-xl border border-emerald-700 bg-emerald-900/40 px-4 py-2 text-emerald-200">
        {{ session('status') }}
      </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
      @forelse($targets as $t)
        <div class="wh-card">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">{{ $t->name }}</h2>
            <span class="wh-chip">{{ strtoupper($t->protocol) }} : {{ $t->host }}:{{ $t->port }}</span>
          </div>

          <p class="wh-muted mt-2">{{ $t->description }}</p>

          <div class="mt-4 flex items-center gap-3">
            {{-- Ouvre la prise de contrôle graphique dans un nouvel onglet --}}
            <a href="http://192.168.230.140:6080/vnc.html?autoconnect=true&password=WhiteHack%212025&resize=scale&autofit=1"
               target="_blank" rel="noopener"
               class="wh-btn-primary">
              Prendre le contrôle (GUI)
            </a>

            {{-- (Optionnel) laisse le bouton SSH si tu l'utilises encore --}}
            @if(Route::has('labs.link'))
              <form method="post" action="{{ route('labs.link', $t->id) }}">
                @csrf
                <button class="wh-btn-secondary">Se connecter (SSH)</button>
              </form>
            @endif
          </div>
        </div>
      @empty
        <div class="wh-muted">Aucune target disponible pour l’instant.</div>
      @endforelse
    </div>

    <p class="mt-6 text-xs text-slate-500">
      ⚠️ Accès restreint au réseau local. Utilisation pédagogique uniquement.
    </p>
  </section>
</x-app-layout>
