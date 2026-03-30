<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
     return redirect()->route('projects.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('projects.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::post('projects/{project}/inputs', [\App\Http\Controllers\ProjectController::class, 'updateInputs'])->name('projects.update-inputs');

    // Simulations
    Route::post('projects/{project}/simulate', [\App\Http\Controllers\SimulationController::class, 'run'])->name('simulations.run');
    Route::get('projects/{project}/scenarios', [\App\Http\Controllers\SimulationController::class, 'multiScenario'])->name('simulations.scenarios');

    // Dashboards
    Route::get('projects/{project}/dashboard', [\App\Http\Controllers\DashboardController::class, 'show'])->name('dashboards.show');
    Route::get('projects/{project}/dashboard/state', [\App\Http\Controllers\DashboardController::class, 'state'])->name('dashboards.state');

    // Projects
    Route::resource('projects', \App\Http\Controllers\ProjectController::class);
    Route::post('projects/{project}/inputs', [\App\Http\Controllers\ProjectController::class, 'updateInputs'])->name('projects.update-inputs');

    // Simulations
    Route::post('projects/{project}/simulate', [\App\Http\Controllers\SimulationController::class, 'run'])->name('simulations.run');
    Route::get('projects/{project}/scenarios', [\App\Http\Controllers\SimulationController::class, 'multiScenario'])->name('simulations.scenarios');

    // Dashboards
    Route::get('projects/{project}/dashboard', [\App\Http\Controllers\DashboardController::class, 'show'])->name('dashboards.show');
    Route::get('projects/{project}/dashboard/state', [\App\Http\Controllers\DashboardController::class, 'state'])->name('dashboards.state');
});

require __DIR__.'/auth.php';
