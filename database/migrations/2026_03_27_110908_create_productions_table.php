<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('year');
            $table->decimal('oil', 15, 3)->default(0);     // Mbbl/year
            $table->decimal('gas', 15, 3)->default(0);     // Bcf/year
            $table->decimal('gnl', 15, 3)->default(0);     // MT LNG/year
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
