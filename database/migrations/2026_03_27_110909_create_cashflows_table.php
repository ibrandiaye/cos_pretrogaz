<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cashflows', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('scenario')->default('base');
            $table->integer('year');
            // Revenues
            $table->decimal('gross_revenue', 15, 2)->default(0);
            $table->decimal('royalties', 15, 2)->default(0);
            $table->decimal('net_revenue', 15, 2)->default(0);
            // Cost recovery
            $table->decimal('recoverable_costs', 15, 2)->default(0);
            $table->decimal('cost_recovery', 15, 2)->default(0);
            // Profit oil/gas
            $table->decimal('profit_oil', 15, 2)->default(0);
            $table->decimal('r_factor', 8, 4)->nullable();
            // Distribution
            $table->decimal('state_share', 15, 2)->default(0);
            $table->decimal('petrosen_share', 15, 2)->default(0);
            $table->decimal('operator_share', 15, 2)->default(0);
            // Taxes
            $table->decimal('income_tax', 15, 2)->default(0);
            $table->decimal('cel', 15, 2)->default(0);
            $table->decimal('export_tax', 15, 2)->default(0);
            // Project cashflows
            $table->decimal('capex_total', 15, 2)->default(0);
            $table->decimal('opex_total', 15, 2)->default(0);
            $table->decimal('project_cashflow', 15, 2)->default(0);
            $table->decimal('discounted_cashflow', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cashflows');
    }
};
