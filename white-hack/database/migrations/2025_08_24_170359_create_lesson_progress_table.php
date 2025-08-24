<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lessons', function (Blueprint $t) {
            $t->id();
            $t->foreignId('module_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->text('markdown')->nullable();
            $t->boolean('is_lab')->default(false);
            $t->unsignedInteger('order')->default(1);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('lessons');
    }
};
