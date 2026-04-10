<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petroleum_codes', function (Blueprint $table) {
            $table->id();
            $table->string('name');                                     // "Code Petrolier 2019", "Code 1998", "Custom Code X"
            $table->string('short_name', 50);                           // "2019", "1998", "CUSTOM1"
            $table->text('description')->nullable();

            // Profit oil split method
            $table->enum('profit_split_method', ['r_factor', 'production'])->default('r_factor');

            // Royalty rates per bloc type (JSON: {onshore: 10, offshore_peu_profond: 9, ...})
            $table->json('royalty_oil_rates');
            $table->decimal('royalty_gas_rate', 5, 2)->default(6);      // single rate for gas

            // Cost recovery ceilings per bloc type (JSON)
            $table->json('cost_recovery_ceilings');

            // Tax rates
            $table->decimal('taux_is', 5, 2)->default(30);
            $table->decimal('cel', 5, 2)->default(1);
            $table->decimal('taxe_export', 5, 2)->default(0);
            $table->decimal('wht_dividendes', 5, 2)->default(5);
            $table->decimal('business_license_tax', 8, 4)->default(0.02);
            $table->decimal('tva', 5, 2)->default(18);

            // Default participations
            $table->decimal('petrosen_participation_default', 5, 2)->default(10);
            $table->decimal('state_participation_default', 5, 2)->default(0);

            // Depreciation
            $table->integer('depreciation_exploration')->default(1);
            $table->integer('depreciation_installations')->default(5);
            $table->integer('depreciation_pipeline_fpso')->default(10);
            $table->integer('nol_years')->default(3);

            // System flag: prevents deletion of built-in codes
            $table->boolean('is_system')->default(false);

            $table->timestamps();
        });

        Schema::create('petroleum_code_tranches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petroleum_code_id')->constrained()->onDelete('cascade');
            $table->integer('order');                                    // 1, 2, 3, 4...
            $table->decimal('threshold_max', 15, 4);                    // R-Factor value OR production (mboed)
            $table->decimal('state_share', 5, 2);                       // % to state (e.g. 40)
            $table->decimal('contractor_share', 5, 2);                  // % to contractor (e.g. 60)
            $table->timestamps();
        });

        // Add FK from projects to petroleum_codes
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('petroleum_code_id')->nullable()->after('code_petrolier')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('petroleum_code_id');
        });
        Schema::dropIfExists('petroleum_code_tranches');
        Schema::dropIfExists('petroleum_codes');
    }
};
