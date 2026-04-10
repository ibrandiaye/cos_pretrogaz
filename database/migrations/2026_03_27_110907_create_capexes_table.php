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
            $table->decimal('etudes_pre_fid', 15, 2)->default(0);
            $table->decimal('forage_completion', 15, 2)->default(0);
            $table->decimal('installations_sous_marines', 15, 2)->default(0);
            $table->decimal('pipeline', 15, 2)->default(0);
            $table->decimal('installations_surface', 15, 2)->default(0);
            $table->decimal('owners_cost', 15, 2)->default(0);
            $table->decimal('imprevus', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('capexes');
    }
};
