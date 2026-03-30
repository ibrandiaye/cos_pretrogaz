<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Parameter;
use App\Models\Capex;
use App\Models\Opex;
use App\Models\Production;
use App\Models\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $projects = $user ? $user->projects : collect();
        
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code_petrolier' => 'required|in:1998,2019',
            'duration' => 'required|integer|min:1|max:50',
            'type' => 'required|in:onshore,offshore',
            'description' => 'nullable|string',
        ]);

        $project = Auth::user()->projects()->create($validated);

        // Initialize default parameters
        $project->parameter()->create([
            'taux_is' => 30,
            'tva' => 18,
            'cel' => 1,
            'redevance_petrole' => 10,
            'redevance_gaz' => 5,
            'cost_recovery_ceiling' => 70,
            'petrosen_participation' => 10,
            'discount_rate' => 10,
        ]);

        // Initialize empty inputs for all years
        for ($y = 1; $y <= $project->duration; $y++) {
            $project->capexes()->create(['year' => $y]);
            $project->opexes()->create(['year' => $y]);
            $project->productions()->create(['year' => $y]);
            $project->prices()->create(['year' => $y]);
        }

        return redirect()->route('projects.show', $project)->with('success', 'Projet créé avec succès.');
    }

    public function show(Project $project)
    {
        $this->authorizeAccess($project);
        $project->load(['parameter', 'capexes', 'opexes', 'productions', 'prices']);
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

        return back()->with('success', 'Données mises à jour.');
    }

    public function destroy(Project $project)
    {
        $this->authorizeAccess($project);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Projet supprimé.');
    }

    private function authorizeAccess(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
