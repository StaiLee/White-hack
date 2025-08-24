<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CourseController extends Controller
{
    public function index() {
        $q = request('q');
        $courses = Course::where('is_published',true)
            ->when($q, fn($qq)=>$qq->where('title','like',"%$q%"))
            ->paginate(9);
        return view('courses.index', compact('courses','q'));
    }

    public function show($slug) {
        $course = Course::with('modules.lessons')
            ->where('slug',$slug)
            ->where('is_published',true)
            ->firstOrFail();
        return view('courses.show', compact('course'));
    }
}
