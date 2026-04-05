<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">Mes Simulations</h1>
            <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">Gerez et analysez vos modeles economiques petroliers</p>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('projects.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Modele
        </a>
    </x-slot>

    @if($projects->isEmpty())
        <div class="card-modern p-5 text-center" style="margin-top: 4rem;">
            <div style="width: 72px; height: 72px; background: var(--accent-light); border-radius: var(--radius-xl); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i class="bi bi-bar-chart-line-fill" style="font-size: 1.75rem; color: var(--accent);"></i>
            </div>
            <h3 class="fw-bold mb-2" style="font-size: 1.25rem;">Aucune simulation</h3>
            <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 1.5rem; font-size: 0.9rem;">
                Modelisez vos revenus, calculez le TRI (IRR) et visualisez vos flux de tresorerie en quelques clics.
            </p>
            <a href="{{ route('projects.create') }}" class="btn btn-accent px-4 py-2">
                <i class="bi bi-plus-lg me-1"></i> Demarrer une modelisation
            </a>
        </div>
    @else
        <!-- Stats Summary -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="kpi-card kpi-blue">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Total Projets</div>
                            <div class="kpi-value" style="color: var(--accent);">{{ $projects->count() }}</div>
                        </div>
                        <div class="kpi-icon" style="background: var(--accent-light);">
                            <i class="bi bi-folder-fill" style="color: var(--accent);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kpi-card kpi-green">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Code 2019</div>
                            <div class="kpi-value" style="color: var(--success);">{{ $projects->where('code_petrolier', '2019')->count() }}</div>
                        </div>
                        <div class="kpi-icon" style="background: #d1fae5;">
                            <i class="bi bi-shield-check" style="color: var(--success);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kpi-card kpi-amber">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Code 1998</div>
                            <div class="kpi-value" style="color: var(--warning);">{{ $projects->where('code_petrolier', '1998')->count() }}</div>
                        </div>
                        <div class="kpi-icon" style="background: #fef3c7;">
                            <i class="bi bi-clock-history" style="color: var(--warning);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="row g-3">
            @foreach($projects as $project)
                <div class="col-md-6 col-xl-4">
                    <div class="card-modern p-4 h-100 d-flex flex-column" style="animation: fadeInUp 0.3s ease {{ $loop->index * 0.05 }}s both;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div style="width: 42px; height: 42px; background: {{ $project->type == 'offshore' ? 'var(--accent-light)' : '#ede9fe' }}; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                <i class="bi {{ $project->type == 'offshore' ? 'bi-water' : 'bi-geo-alt-fill' }}" style="font-size: 1.1rem; color: {{ $project->type == 'offshore' ? 'var(--accent)' : '#7c3aed' }};"></i>
                            </div>
                            <span class="badge-modern {{ $project->code_petrolier == '2019' ? 'badge-blue' : 'badge-amber' }}">
                                CODE {{ $project->code_petrolier }}
                            </span>
                        </div>

                        <h5 class="fw-bold mb-1 text-truncate" style="font-size: 1.05rem;">{{ $project->name }}</h5>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.4rem;">
                            {{ $project->description ?: 'Aucune description disponible pour ce modele.' }}
                        </p>

                        <div class="d-flex gap-4 mb-3 pb-3" style="border-bottom: 1px solid var(--border-light);">
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Horizon</div>
                                <div class="fw-bold" style="font-size: 0.9rem;">{{ $project->duration }} ans</div>
                            </div>
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Type</div>
                                <div class="fw-bold" style="font-size: 0.9rem;">{{ ucfirst($project->type) }}</div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-ghost flex-fill">
                                <i class="bi bi-sliders me-1"></i> Gerer
                            </a>
                            <a href="{{ route('dashboards.show', $project) }}" class="btn btn-dark-modern flex-fill">
                                <i class="bi bi-graph-up me-1"></i> Analytics
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-app-layout>
