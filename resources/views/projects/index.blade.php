<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-black text-dark mb-0">Mes Simulations</h2>
                <p class="text-muted small mb-0 font-medium">Gérez et analysez vos modèles économiques pétroliers.</p>
            </div>
            <a href="{{ route('projects.create') }}" class="btn btn-primary-premium btn-premium shadow">
                Nouveau Modèle
            </a>
        </div>
    </x-slot>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 py-3 px-4 fw-bold">
                {{ session('success') }}
            </div>
        @endif

        @if($projects->isEmpty())
            <div class="card-premium p-5 text-center my-5">
                <div class="bg-light rounded-circle p-4 d-inline-block mb-4">
                    <svg class="text-primary" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="fw-black text-dark">Simulations Pétrolières</h3>
                <p class="text-muted mx-auto" style="max-width: 400px;">Modélisez vos revenus, calculez le TRI (IRR) et visualisez vos flux de trésorerie en quelques clics.</p>
                <a href="{{ route('projects.create') }}" class="btn btn-primary-premium btn-premium px-5 py-3 mt-3">Démarrer une modélisation</a>
            </div>
        @else
            <div class="row g-4">
                @foreach($projects as $project)
                    <div class="col-md-6 col-lg-4">
                        <div class="card card-premium h-100 p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="bg-light p-3 rounded-4">
                                    <svg class="text-muted" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                </div>
                                <span class="badge {{ $project->code_petrolier == '2019' ? 'bg-info-subtle text-info' : 'bg-warning-subtle text-warning' }} border fw-black px-3 py-2 rounded-pill">
                                    CODE {{ $project->code_petrolier }}
                                </span>
                            </div>
                            
                            <h4 class="fw-black text-dark mb-2 text-truncate">{{ $project->name }}</h4>
                            <p class="text-muted small mb-4 line-clamp-2" style="height: 3rem;">
                                {{ $project->description ?: 'Aucune description détaillée n’est disponible pour ce modèle économique.' }}
                            </p>
                            
                            <hr class="opacity-10 mb-4">
                            
                            <div class="row mb-4">
                                <div class="col-6">
                                    <p class="text-muted xsmall fw-black text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">Horizon</p>
                                    <p class="fw-bold text-dark mb-0 small">{{ $project->duration }} ans</p>
                                </div>
                                <div class="col-6">
                                    <p class="text-muted xsmall fw-black text-uppercase mb-1" style="font-size: 0.65rem; letter-spacing: 0.5px;">Domaine</p>
                                    <p class="fw-bold text-dark mb-0 small">{{ ucfirst($project->type) }}</p>
                                </div>
                            </div>

                            <div class="d-flex gap-2 mt-auto">
                                <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary w-100 fw-bold border-2 rounded-3">Gérer</a>
                                <a href="{{ route('dashboards.show', $project) }}" class="btn btn-dark w-100 fw-bold rounded-3">Analytics</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
