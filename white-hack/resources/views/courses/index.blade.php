<x-app-layout>
  <div class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-semibold">Catalogue des cours</h1>
      <form method="get">
        <input type="search" name="q" value="{{ $q }}" placeholder="Rechercher…"
               class="bg-slate-900 border border-slate-700 rounded-xl px-3 py-2 text-slate-200">
      </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
      @foreach($courses as $course)
        <a href="{{ route('courses.show',$course->slug) }}"
           class="block rounded-2xl bg-slate-900/60 hover:bg-slate-900 border border-slate-700 p-5 transition">
          <div class="text-sm text-teal-400 mb-2 uppercase">{{ ucfirst($course->level) }}</div>
          <h2 class="text-lg font-bold mb-2">{{ $course->title }}</h2>
          <p class="text-slate-300 line-clamp-2">{{ $course->description }}</p>
          <div class="mt-4 text-slate-400 text-sm">{{ $course->duration_min }} min</div>
        </a>
      @endforeach
    </div>

    <div class="mt-6">{{ $courses->links() }}</div>
  </div>
</x-app-layout>
