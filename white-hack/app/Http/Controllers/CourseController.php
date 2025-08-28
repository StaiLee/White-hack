<?php
// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index()
    {
        $q      = request('q');
        $active = request('level'); // 'easy' | 'mid' | 'hard' | null

        // Mapping UI -> DB
        $map = [
            'easy' => 'debutant',
            'mid'  => 'intermediaire',
            'hard' => 'avance',
        ];
        $dbLevel = $map[$active] ?? null;

        // Base query
        $query = Course::where('is_published', true)
            ->when($q, fn($qq) => $qq->where('title', 'like', "%$q%"));

        // Filtre niveau si demandé
        if ($dbLevel) {
            $query->where('level', $dbLevel);
        }

        $courses = $query->orderBy('created_at', 'desc')->paginate(12);

        // Compteurs par niveau pour les pastilles
        $counts = Course::where('is_published', true)
            ->select('level', DB::raw('COUNT(*) as c'))
            ->groupBy('level')
            ->pluck('c', 'level');

        $countAll  = Course::where('is_published', true)->count();
        $countEasy = $counts['debutant']      ?? 0;
        $countMid  = $counts['intermediaire'] ?? 0;
        $countHard = $counts['avance']        ?? 0;

        return view('courses.index', compact(
            'courses', 'q', 'active', 'countAll', 'countEasy', 'countMid', 'countHard'
        ));
    }

    public function show($slug)
    {
        $course = Course::with('modules.lessons')
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $modules = $course->modules; // par commodité dans la vue
        return view('courses.show', compact('course', 'modules'));
    }
}
