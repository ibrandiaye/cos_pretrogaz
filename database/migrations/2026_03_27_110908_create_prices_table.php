<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->integer('year');
            $table->decimal('oil_price', 10, 2)->default(70);      // $/bbl (Brent)
            $table->decimal('gas_price', 10, 2)->default(3);       // $/MMBTU (NBP)
            $table->decimal('gnl_price', 10, 2)->default(10);      // $/MMBTU (TTF)
            $table->decimal('gas_domestic_price', 10, 2)->default(2); // $/MMBTU
            $table->decimal('inflation', 5, 2)->default(2);         // %
            $table->decimal('exchange_rate', 10, 4)->default(600);  // FCFA/USD
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
