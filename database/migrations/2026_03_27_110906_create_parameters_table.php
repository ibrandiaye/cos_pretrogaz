<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            // Fiscal
            $table->decimal('taux_is', 5, 2)->default(30);           // IS %
            $table->decimal('tva', 5, 2)->default(18);                // TVA %
            $table->decimal('cel', 5, 2)->default(1);                 // CEL %
            $table->decimal('taxe_export', 5, 2)->default(0);         // Taxe export %
            $table->decimal('redevance_petrole', 5, 2)->default(10);  // Redevance pétrole %
            $table->decimal('redevance_gaz', 5, 2)->default(5);       // Redevance gaz %
            $table->decimal('taxe_carbone', 8, 2)->default(0);        // Taxe carbone $/tonne
            // Contractual
            $table->decimal('petrosen_participation', 5, 2)->default(10);    // %
            $table->decimal('state_participation', 5, 2)->default(0);        // % (carried interest)
            $table->decimal('cost_recovery_ceiling', 5, 2)->default(70);     // % max cost recovery
            $table->decimal('bonus_signature', 12, 2)->default(0);           // $
            $table->decimal('bonus_production', 12, 2)->default(0);          // $
            // Financing PETROSEN
            $table->decimal('petrosen_loan_amount', 15, 2)->default(0);
            $table->decimal('petrosen_interest_rate', 5, 2)->default(7);
            $table->integer('petrosen_grace_period')->default(2);
            $table->integer('petrosen_maturity')->default(10);
            // Discount rate for NPV
            $table->decimal('discount_rate', 5, 2)->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parameters');
    }
};
