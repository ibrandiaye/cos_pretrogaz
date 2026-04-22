<?php

namespace App\Http\Controllers;

use App\Models\PetroleumCode;
use App\Models\PetroleumCodeTranche;
use Illuminate\Http\Request;

class PetroleumCodeController extends Controller
{
    public function index()
    {
        $codes = PetroleumCode::withCount('tranches', 'projects')->get();
        return view('petroleum-codes.index', compact('codes'));
    }

    public function create()
    {
        return view('petroleum-codes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:50|unique:petroleum_codes,short_name',
            'description' => 'nullable|string',
            'profit_split_method' => 'required|in:r_factor,production',
            'royalty_oil_onshore' => 'required|numeric|min:0|max:100',
            'royalty_oil_offshore_peu_profond' => 'required|numeric|min:0|max:100',
            'royalty_oil_offshore_profond' => 'required|numeric|min:0|max:100',
            'royalty_oil_offshore_ultra_profond' => 'required|numeric|min:0|max:100',
            'royalty_gas_rate' => 'required|numeric|min:0|max:100',
            'cr_onshore' => 'required|numeric|min:0|max:100',
            'cr_offshore_peu_profond' => 'required|numeric|min:0|max:100',
            'cr_offshore_profond' => 'required|numeric|min:0|max:100',
            'cr_offshore_ultra_profond' => 'required|numeric|min:0|max:100',
            'taux_is' => 'required|numeric|min:0|max:100',
            'cel' => 'required|numeric|min:0|max:100',
            'taxe_export' => 'required|numeric|min:0|max:100',
            'wht_dividendes' => 'required|numeric|min:0|max:100',
            'business_license_tax' => 'required|numeric|min:0|max:100',
            'tva' => 'required|numeric|min:0|max:100',
            'petrosen_participation_default' => 'required|numeric|min:0|max:100',
            'state_participation_default' => 'required|numeric|min:0|max:100',
            'depreciation_exploration' => 'required|integer|min:1|max:30',
            'depreciation_installations' => 'required|integer|min:1|max:30',
            'depreciation_pipeline_fpso' => 'required|integer|min:1|max:30',
            'nol_years' => 'required|integer|min:0|max:10',
            'tranches' => 'required|array|min:1',
            'tranches.*.threshold_max' => 'required|numeric|min:0',
            'tranches.*.state_share' => 'required|numeric|min:0|max:100',
            'tranches.*.contractor_share' => 'required|numeric|min:0|max:100',
        ]);

        $code = PetroleumCode::create([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'],
            'description' => $validated['description'],
            'profit_split_method' => $validated['profit_split_method'],
            'royalty_oil_rates' => [
                'onshore' => $validated['royalty_oil_onshore'],
                'offshore_peu_profond' => $validated['royalty_oil_offshore_peu_profond'],
                'offshore_profond' => $validated['royalty_oil_offshore_profond'],
                'offshore_ultra_profond' => $validated['royalty_oil_offshore_ultra_profond'],
            ],
            'royalty_gas_rate' => $validated['royalty_gas_rate'],
            'cost_recovery_ceilings' => [
                'onshore' => $validated['cr_onshore'],
                'offshore_peu_profond' => $validated['cr_offshore_peu_profond'],
                'offshore_profond' => $validated['cr_offshore_profond'],
                'offshore_ultra_profond' => $validated['cr_offshore_ultra_profond'],
            ],
            'taux_is' => $validated['taux_is'],
            'cel' => $validated['cel'],
            'taxe_export' => $validated['taxe_export'],
            'wht_dividendes' => $validated['wht_dividendes'],
            'business_license_tax' => $validated['business_license_tax'],
            'tva' => $validated['tva'],
            'petrosen_participation_default' => $validated['petrosen_participation_default'],
            'state_participation_default' => $validated['state_participation_default'],
            'depreciation_exploration' => $validated['depreciation_exploration'],
            'depreciation_installations' => $validated['depreciation_installations'],
            'depreciation_pipeline_fpso' => $validated['depreciation_pipeline_fpso'],
            'nol_years' => $validated['nol_years'],
            'is_system' => false,
        ]);

        foreach ($validated['tranches'] as $i => $tranche) {
            $code->tranches()->create([
                'order' => $i + 1,
                'threshold_max' => $tranche['threshold_max'],
                'state_share' => $tranche['state_share'],
                'contractor_share' => $tranche['contractor_share'],
            ]);
        }

        return redirect()->route('petroleum-codes.index')->with('success', 'Code petrolier cree avec succes.');
    }

    public function show(PetroleumCode $petroleumCode)
    {
        $petroleumCode->load('tranches');
        return view('petroleum-codes.show', compact('petroleumCode'));
    }

    public function edit(PetroleumCode $petroleumCode)
    {
        $petroleumCode->load('tranches');
        return view('petroleum-codes.edit', compact('petroleumCode'));
    }

    public function update(Request $request, PetroleumCode $petroleumCode)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string|max:50|unique:petroleum_codes,short_name,' . $petroleumCode->id,
            'description' => 'nullable|string',
            'profit_split_method' => 'required|in:r_factor,production',
            'royalty_oil_onshore' => 'required|numeric|min:0|max:100',
            'royalty_oil_offshore_peu_profond' => 'required|numeric|min:0|max:100',
            'royalty_oil_offshore_profond' => 'required|numeric|min:0|max:100',
            'royalty_oil_offshore_ultra_profond' => 'required|numeric|min:0|max:100',
            'royalty_gas_rate' => 'required|numeric|min:0|max:100',
            'cr_onshore' => 'required|numeric|min:0|max:100',
            'cr_offshore_peu_profond' => 'required|numeric|min:0|max:100',
            'cr_offshore_profond' => 'required|numeric|min:0|max:100',
            'cr_offshore_ultra_profond' => 'required|numeric|min:0|max:100',
            'taux_is' => 'required|numeric|min:0|max:100',
            'cel' => 'required|numeric|min:0|max:100',
            'taxe_export' => 'required|numeric|min:0|max:100',
            'wht_dividendes' => 'required|numeric|min:0|max:100',
            'business_license_tax' => 'required|numeric|min:0|max:100',
            'tva' => 'required|numeric|min:0|max:100',
            'petrosen_participation_default' => 'required|numeric|min:0|max:100',
            'state_participation_default' => 'required|numeric|min:0|max:100',
            'depreciation_exploration' => 'required|integer|min:1|max:30',
            'depreciation_installations' => 'required|integer|min:1|max:30',
            'depreciation_pipeline_fpso' => 'required|integer|min:1|max:30',
            'nol_years' => 'required|integer|min:0|max:10',
            'tranches' => 'required|array|min:1',
            'tranches.*.threshold_max' => 'required|numeric|min:0',
            'tranches.*.state_share' => 'required|numeric|min:0|max:100',
            'tranches.*.contractor_share' => 'required|numeric|min:0|max:100',
        ]);

        $petroleumCode->update([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'],
            'description' => $validated['description'],
            'profit_split_method' => $validated['profit_split_method'],
            'royalty_oil_rates' => [
                'onshore' => $validated['royalty_oil_onshore'],
                'offshore_peu_profond' => $validated['royalty_oil_offshore_peu_profond'],
                'offshore_profond' => $validated['royalty_oil_offshore_profond'],
                'offshore_ultra_profond' => $validated['royalty_oil_offshore_ultra_profond'],
            ],
            'royalty_gas_rate' => $validated['royalty_gas_rate'],
            'cost_recovery_ceilings' => [
                'onshore' => $validated['cr_onshore'],
                'offshore_peu_profond' => $validated['cr_offshore_peu_profond'],
                'offshore_profond' => $validated['cr_offshore_profond'],
                'offshore_ultra_profond' => $validated['cr_offshore_ultra_profond'],
            ],
            'taux_is' => $validated['taux_is'],
            'cel' => $validated['cel'],
            'taxe_export' => $validated['taxe_export'],
            'wht_dividendes' => $validated['wht_dividendes'],
            'business_license_tax' => $validated['business_license_tax'],
            'tva' => $validated['tva'],
            'petrosen_participation_default' => $validated['petrosen_participation_default'],
            'state_participation_default' => $validated['state_participation_default'],
            'depreciation_exploration' => $validated['depreciation_exploration'],
            'depreciation_installations' => $validated['depreciation_installations'],
            'depreciation_pipeline_fpso' => $validated['depreciation_pipeline_fpso'],
            'nol_years' => $validated['nol_years'],
        ]);

        // Replace tranches
        $petroleumCode->tranches()->delete();
        foreach ($validated['tranches'] as $i => $tranche) {
            $petroleumCode->tranches()->create([
                'order' => $i + 1,
                'threshold_max' => $tranche['threshold_max'],
                'state_share' => $tranche['state_share'],
                'contractor_share' => $tranche['contractor_share'],
            ]);
        }

        return redirect()->route('petroleum-codes.index')->with('success', 'Code petrolier mis a jour.');
    }

    public function destroy(PetroleumCode $petroleumCode)
    {
        if ($petroleumCode->is_system) {
            return back()->with('error', 'Impossible de supprimer un code petrolier systeme.');
        }

        if ($petroleumCode->projects()->count() > 0) {
            return back()->with('error', 'Ce code est utilise par des projets existants.');
        }

        $petroleumCode->delete();
        return redirect()->route('petroleum-codes.index')->with('success', 'Code petrolier supprime.');
    }

    /**
     * Duplicate an existing petroleum code.
     */
    public function duplicate(PetroleumCode $petroleumCode)
    {
        $newCode = $petroleumCode->replicate();
        $newCode->name = $petroleumCode->name . ' (Copie)';
        $newCode->short_name = $petroleumCode->short_name . '_COPY';
        $newCode->is_system = false;
        $newCode->save();

        foreach ($petroleumCode->tranches as $tranche) {
            $newTranche = $tranche->replicate();
            $newTranche->petroleum_code_id = $newCode->id;
            $newTranche->save();
        }

        return redirect()->route('petroleum-codes.edit', $newCode)->with('success', 'Code duplique. Modifiez-le selon vos besoins.');
    }
}
