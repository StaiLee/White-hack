<x-app-layout>
  <div class="max-w-6xl mx-auto p-6">
    <a href="{{ route('courses.index') }}" class="text-slate-400 hover:text-slate-200">&larr; Retour</a>

    <div class="mt-3 flex items-center justify-between">
      <h1 class="text-2xl font-semibold">{{ $course->title }}</h1>
      <span class="px-3 py-1 rounded-lg bg-slate-800 border border-slate-700 text-sm">
        Niveau : {{ ucfirst($course->level) }}
      </span>
    </div>
    <p class="text-slate-300 mt-2">{{ $course->description }}</p>

    <div class="mt-8 grid md:grid-cols-2 gap-6">
      @foreach($course->modules as $module)
        <div class="rounded-2xl bg-slate-900/60 border border-slate-700 p-5">
          <h3 class="font-semibold mb-3">{{ $module->title }}</h3>
          <ul class="space-y-2">
            @foreach($module->lessons as $lesson)
              <li class="flex items-center justify-between">
                <span>{{ $lesson->title }}</span>
                @if($lesson->is_lab)
                  <span class="text-xs px-2 py-1 rounded bg-cyan-700/40 border border-cyan-700">LAB</span>
                @endif
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>

    <div class="mt-8 flex gap-4">
      <a href="{{ route('practice.index') }}" class="px-4 py-2 rounded-xl bg-cyan-600 hover:bg-cyan-500">
        Aller à la pratique
      </a>
    </div>
  </div>
</x-app-layout>
