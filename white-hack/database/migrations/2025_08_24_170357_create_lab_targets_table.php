<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('lab_targets', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('host');           // IP/hostname de la VM cible
            $t->unsignedInteger('port')->default(22);
            $t->enum('protocol',['ssh','rdp','vnc'])->default('ssh');
            $t->text('description')->nullable();
            $t->boolean('enabled')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('lab_targets');
    }
};
