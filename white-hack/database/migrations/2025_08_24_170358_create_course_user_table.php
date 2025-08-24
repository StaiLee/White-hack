<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('course_user', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('course_id')->constrained()->cascadeOnDelete();
            $t->enum('status',['en_cours','termine'])->default('en_cours');
            $t->unsignedTinyInteger('progress_pct')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('course_user');
    }
};
