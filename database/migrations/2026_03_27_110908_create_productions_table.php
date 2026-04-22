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
            // Inputs en taux journaliers (comme le fichier Excel)
            $table->decimal('petrole_jour', 15, 4)->default(0);          // mbaril/jour
            $table->decimal('gaz_domestique_jour', 15, 4)->default(0);   // mmscf/jour
            $table->decimal('gnl_jour', 15, 4)->default(0);              // mmscf/jour
            $table->decimal('gaz_combustible_pertes', 15, 4)->default(0); // mmscf/jour
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
