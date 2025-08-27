{{-- resources/views/courses/show.blade.php --}}
<x-app-layout>
  <section class="wh-container py-10">
    <a href="{{ route('courses.index') }}" class="text-slate-400 hover:text-slate-200">&larr; Retour aux cours</a>

    @php
      $modulesSorted = $course->modules->sortBy('order');
      $firstModule   = $modulesSorted->first();
      $firstLesson   = $firstModule?->lessons->sortBy('order')->first(); // Lesson|null
      $modulesCount  = $modulesSorted->count();
      $lessonsCount  = $modulesSorted->flatMap->lessons->count();
    @endphp

    {{-- HERO --}}
    <div class="relative mt-4 overflow-hidden rounded-3xl border border-slate-800 bg-gradient-to-tr from-slate-900 via-slate-900/80 to-slate-900 p-6 md:p-8">
      <div class="pointer-events-none absolute -right-16 -top-16 h-56 w-56 rounded-full bg-cyan-500/10 blur-3xl"></div>
      <div class="pointer-events-none absolute -left-10 -bottom-16 h-56 w-56 rounded-full bg-emerald-500/10 blur-3xl"></div>

      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
          <h1 class="text-3xl font-semibold">{{ $course->title }}</h1>
          <p class="wh-muted mt-2 max-w-3xl">{{ $course->description }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
          <span class="wh-chip">Niveau : {{ ucfirst($course->level) }}</span>
          <span class="wh-chip">{{ $course->duration_min }} min</span>
          <span class="wh-chip">{{ $modulesCount }} modules</span>
          <span class="wh-chip">{{ $lessonsCount }} leçons</span>
        </div>
      </div>

      <div class="mt-6">
        @if($firstLesson)
          <a href="{{ route('lessons.show', ['lesson' => $firstLesson->id]) }}" class="wh-btn-primary">Commencer le cours</a>
        @endif
        <a href="{{ route('practice.index') }}" class="wh-btn-secondary ml-2">Aller aux labs</a>
      </div>
    </div>

    {{-- CONTENU --}}
    <div class="mt-8 grid gap-6 lg:grid-cols-3">
      {{-- Modules / leçons --}}
      <div class="lg:col-span-2 space-y-4">
        @foreach($modulesSorted as $module)
          <details class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60" {{ $loop->first ? 'open' : '' }}>
            <summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-5 py-4 hover:bg-slate-900">
              <div class="flex items-center gap-3">
                <span class="rounded-xl bg-slate-800 px-2.5 py-1 text-xs">{{ str_pad($module->order,2,'0',STR_PAD_LEFT) }}</span>
                <h3 class="font-semibold">{{ $module->title }}</h3>
              </div>
              <span class="text-sm text-slate-400">{{ $module->lessons->count() }} leçon(s)</span>
            </summary>

            <ul class="divide-y divide-slate-800">
              @foreach($module->lessons->sortBy('order') as $lesson)
                <li class="group flex items-center justify-between px-5 py-3 hover:bg-slate-900">
                  <div class="flex items-center gap-3">
                    <span class="w-8 text-xs text-slate-500">{{ str_pad($lesson->order,2,'0',STR_PAD_LEFT) }}</span>
                    <a href="{{ route('lessons.show', ['lesson' => $lesson->id]) }}" class="hover:underline">
                      {{ $lesson->title }}
                    </a>
                  </div>
                  <div class="flex items-center gap-2">
                    @if($lesson->is_lab)
                      <span class="wh-chip bg-cyan-700/40 border-cyan-700">LAB</span>
                    @endif
                    <a href="{{ route('lessons.show', ['lesson' => $lesson->id]) }}"
                       class="rounded-xl border border-slate-800 bg-slate-900 px-3 py-1.5 text-sm text-slate-200 transition hover:bg-slate-800">
                      Ouvrir →
                    </a>
                  </div>
                </li>
              @endforeach
            </ul>
          </details>
        @endforeach
      </div>

      {{-- Aside --}}
      <aside class="space-y-4">
        <div class="wh-card">
          <h4 class="mb-2 font-semibold">À propos de ce cours</h4>
          <ul class="space-y-2 text-sm text-slate-300">
            <li>• Adressage **IP** (IPv4/IPv6, CIDR) & **subnetting**.</li>
            <li>• **NAT / DNS / passerelle** (fondamentaux).</li>
            <li>• Lire une **table de routage** & diagnostiquer une panne.</li>
            <li>• Préparer la pratique **Nmap**, logs & durcissement.</li>
          </ul>
        </div>

        <div class="wh-card">
          <h4 class="mb-2 font-semibold">Prérequis conseillés</h4>
          <ul class="space-y-2 text-sm text-slate-300">
            <li>• Bases Linux/Windows (terminal, IP).</li>
            <li>• Accès à un **lab autorisé** (VM, Raspberry, etc.).</li>
          </ul>
        </div>

        <div class="wh-card">
          <h4 class="mb-2 font-semibold">Prochaines étapes</h4>
          <ul class="space-y-2 text-sm text-slate-300">
            <li>• Lancer le **TP diagnostic**.</li>
            <li>• Enchaîner avec **Nmap**.</li>
            <li>• Poursuivre avec **SQLi (éthique)**.</li>
          </ul>
        </div>
      </aside>
    </div>
  </section>
</x-app-layout>
