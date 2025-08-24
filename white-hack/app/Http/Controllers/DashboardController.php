<?php

namespace App\Http\Controllers;

use App\Models\Course;

class DashboardController extends Controller
{
    public function index() {
        $courses = Course::where('is_published',true)->latest()->take(6)->get();
        return view('dashboard', compact('courses'));
    }
}
