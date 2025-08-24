<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $t) {
  $t->id();
  $t->string('title');
  $t->string('slug')->unique();
  $t->enum('level',['debutant','intermediaire','avance'])->default('debutant');
  $t->unsignedInteger('duration_min')->default(60);
  $t->text('description')->nullable();
  $t->boolean('is_published')->default(false);
  $t->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
