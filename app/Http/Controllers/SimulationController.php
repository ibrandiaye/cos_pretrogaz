<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\EconomicModelService;
use Illuminate\Http\Request;

class SimulationController extends Controller
{
    protected $economicService;

    public function __construct(EconomicModelService $economicService)
    {
        $this->economicService = $economicService;
    }

    public function run(Project $project)
    {
        $results = $this->economicService->runSimulation($project);
        
        if (isset($results['error'])) {
            return back()->with('error', $results['error']);
        }

        $this->economicService->saveSimulation($project, $results);

        return redirect()->route('dashboards.show', $project)->with('success', 'Simulation terminée avec succès.');
    }

    public function multiScenario(Project $project)
    {
        $scenarios = $this->economicService->runMultiScenario($project);
        return view('simulations.multi', compact('project', 'scenarios'));
    }
}
