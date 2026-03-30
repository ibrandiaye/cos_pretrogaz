<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('capexes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('year');
            $table->decimal('exploration', 15, 2)->default(0);
            $table->decimal('development', 15, 2)->default(0);
            $table->decimal('pipeline_fpso', 15, 2)->default(0);
            $table->decimal('installations', 15, 2)->default(0);
            $table->decimal('divers', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capexes');
    }
};
