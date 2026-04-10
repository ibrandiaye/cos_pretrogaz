<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            // Bloc type for differentiated royalties & cost recovery (2019 code)
            $table->enum('bloc_type', ['onshore', 'offshore_peu_profond', 'offshore_profond', 'offshore_ultra_profond'])
                  ->default('offshore_profond')->after('cost_recovery_ceiling');

            // Additional taxes from Excel model
            $table->decimal('wht_dividendes', 5, 2)->default(5)->after('taxe_carbone');       // Withholding tax on dividends %
            $table->decimal('business_license_tax', 8, 4)->default(0.02)->after('wht_dividendes'); // BLT % (0.02% = 0.0002)

            // Depreciation durations (years) for cost recovery
            $table->integer('depreciation_exploration')->default(1)->after('business_license_tax');
            $table->integer('depreciation_installations')->default(5)->after('depreciation_exploration');
            $table->integer('depreciation_pipeline_fpso')->default(10)->after('depreciation_installations');

            // Net Operating Loss carry-forward limit
            $table->integer('nol_years')->default(3)->after('depreciation_pipeline_fpso');

            // Abandonment costs
            $table->decimal('abandonment_provision', 5, 2)->default(0)->after('nol_years'); // % of capex
        });

        Schema::table('cashflows', function (Blueprint $table) {
            $table->decimal('wht_dividendes', 15, 2)->default(0)->after('export_tax');
            $table->decimal('business_license_tax', 15, 2)->default(0)->after('wht_dividendes');
            $table->decimal('depreciation', 15, 2)->default(0)->after('business_license_tax');
        });
    }

    public function down(): void
    {
        Schema::table('parameters', function (Blueprint $table) {
            $table->dropColumn([
                'bloc_type', 'wht_dividendes', 'business_license_tax',
                'depreciation_exploration', 'depreciation_installations', 'depreciation_pipeline_fpso',
                'nol_years', 'abandonment_provision',
            ]);
        });

        Schema::table('cashflows', function (Blueprint $table) {
            $table->dropColumn(['wht_dividendes', 'business_license_tax', 'depreciation']);
        });
    }
};
