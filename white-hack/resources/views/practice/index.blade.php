<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Pratique (Labs)</h1>
    @if (session('status'))
      <div class="mb-4 px-4 py-2 rounded-lg bg-emerald-900/40 border border-emerald-700 text-emerald-200">
        {{ session('status') }}
      </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
      @forelse($targets as $t)
        <div class="rounded-2xl bg-slate-900/60 border border-slate-700 p-5">
          <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">{{ $t->name }}</h2>
            <span class="text-xs px-2 py-1 rounded bg-slate-800 border border-slate-700">
              {{ strtoupper($t->protocol) }} : {{ $t->host }}:{{ $t->port }}
            </span>
          </div>
          <p class="text-slate-300 mt-2">{{ $t->description }}</p>
          <form method="post" action="{{ route('labs.link',$t->id) }}" class="mt-4">
            @csrf
            <button class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500">Se connecter</button>
          </form>
        </div>
      @empty
        <div class="text-slate-400">Aucune target disponible pour l’instant.</div>
      @endforelse
    </div>
  </div>
</x-app-layout>
