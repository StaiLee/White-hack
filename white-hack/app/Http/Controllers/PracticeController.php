<?php

namespace App\Http\Controllers;

use App\Models\LabTarget;

class PracticeController extends Controller
{
    public function index() {
        $targets = LabTarget::where('enabled',true)->get();
        return view('practice.index', compact('targets'));
    }
}
