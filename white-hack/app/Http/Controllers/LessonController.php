<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class LessonController extends Controller
{
    public function show(Lesson $lesson)
    {
        // charger relations
        $lesson->load('module.course');

        // rendu Markdown
        $converter = new GithubFlavoredMarkdownConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
        $html = $converter->convert($lesson->markdown ?? '')->getContent();

        // navigation prev/next dans le module
        $siblings = $lesson->module->lessons()->orderBy('order')->get();
        $index = $siblings->search(fn($l) => $l->id === $lesson->id);
        $prev  = $index > 0 ? $siblings[$index - 1] : null;
        $next  = ($index !== false && $index < $siblings->count() - 1) ? $siblings[$index + 1] : null;

        return view('lessons.show', compact('lesson', 'html', 'prev', 'next'));
    }
}
