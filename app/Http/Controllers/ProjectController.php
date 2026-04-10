<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\PetroleumCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = $user ? $user->projects()->with('petroleumCode')->get() : collect();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $petroleumCodes = PetroleumCode::orderBy('name')->get();
        return view('projects.create', compact('petroleumCodes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'petroleum_code_id' => 'required|exists:petroleum_codes,id',
            'duration' => 'required|integer|min:1|max:50',
            'type' => 'required|in:onshore,offshore',
            'description' => 'nullable|string',
        ]);

        $petroleumCode = PetroleumCode::findOrFail($validated['petroleum_code_id']);

        // Keep code_petrolier for backwards compatibility
        $validated['code_petrolier'] = $petroleumCode->short_name;

        $project = Auth::user()->projects()->create($validated);

        // Build default parameters from the petroleum code
        $blocType = $validated['type'] === 'onshore' ? 'onshore' : 'offshore_profond';
        $project->parameter()->create([
            'taux_is' => $petroleumCode->taux_is,
            'tva' => $petroleumCode->tva,
            'cel' => $petroleumCode->cel,
            'taxe_export' => $petroleumCode->taxe_export,
            'wht_dividendes' => $petroleumCode->wht_dividendes,
            'business_license_tax' => $petroleumCode->business_license_tax,
            'redevance_petrole' => $petroleumCode->getRoyaltyOilRate($blocType),
            'redevance_gaz' => $petroleumCode->royalty_gas_rate,
            'cost_recovery_ceiling' => $petroleumCode->getCostRecoveryCeiling($blocType),
            'bloc_type' => $blocType,
            'petrosen_participation' => $petroleumCode->petrosen_participation_default,
            'state_participation' => $petroleumCode->state_participation_default,
            'discount_rate' => 10,
            'depreciation_exploration' => $petroleumCode->depreciation_exploration,
            'depreciation_installations' => $petroleumCode->depreciation_installations,
            'depreciation_pipeline_fpso' => $petroleumCode->depreciation_pipeline_fpso,
            'nol_years' => $petroleumCode->nol_years,
            'abandonment_provision' => 0,
        ]);

        // Initialize empty inputs for all years
        for ($y = 1; $y <= $project->duration; $y++) {
            $project->capexes()->create(['year' => $y]);
            $project->opexes()->create(['year' => $y]);
            $project->productions()->create(['year' => $y]);
            $project->prices()->create(['year' => $y]);
        }

        return redirect()->route('projects.show', $project)->with('success', 'Projet cree avec succes.');
    }

    public function show(Project $project)
    {
        $this->authorizeAccess($project);
        $project->load(['parameter', 'capexes', 'opexes', 'productions', 'prices', 'petroleumCode']);
        return view('projects.show', compact('project'));
    }

    public function updateInputs(Request $request, Project $project)
    {
        $this->authorizeAccess($project);

        $type = $request->input('type');
        $inputs = $request->input('inputs', []);

        foreach ($inputs as $year => $data) {
            switch ($type) {
                case 'parameters':
                    $project->parameter()->update($data);
                    break;
                case 'capex':
                    $project->capexes()->where('year', $year)->update($data);
                    break;
                case 'opex':
                    $project->opexes()->where('year', $year)->update($data);
                    break;
                case 'production':
                    $project->productions()->where('year', $year)->update($data);
                    break;
                case 'price':
                    $project->prices()->where('year', $year)->update($data);
                    break;
            }
        }

        return back()->with('success', 'Donnees mises a jour.');
    }

    public function destroy(Project $project)
    {
        $this->authorizeAccess($project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprime.');
    }

    private function authorizeAccess(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
