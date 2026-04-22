<x-app-layout>
    <x-slot name="header">
        <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">Codes Petroliers</h1>
        <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">Gerez les regimes fiscaux et contractuels applicables</p>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('petroleum-codes.create') }}" class="btn btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Code
        </a>
    </x-slot>

    <div class="row g-3 animate-in">
        @forelse($codes as $code)
            <div class="col-lg-6 col-xl-4">
                <div class="card-modern p-0 overflow-hidden h-100">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-bold mb-1" style="font-size: 1rem;">{{ $code->name }}</h5>
                                <div class="d-flex gap-2">
                                    <span class="badge-modern badge-blue">{{ $code->short_name }}</span>
                                    <span class="badge-modern {{ $code->profit_split_method === 'r_factor' ? 'badge-green' : 'badge-amber' }}">
                                        {{ $code->profit_split_method === 'r_factor' ? 'R-Factor' : 'Production' }}
                                    </span>
                                    @if($code->is_system)
                                        <span class="badge-modern badge-purple">Systeme</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 1rem 1.5rem;">
                        <div class="row g-2" style="font-size: 0.8rem;">
                            <div class="col-6">
                                <div style="color: var(--text-muted);">IS</div>
                                <div class="fw-bold">{{ $code->taux_is }}%</div>
                            </div>
                            <div class="col-6">
                                <div style="color: var(--text-muted);">Redevance Gaz</div>
                                <div class="fw-bold">{{ $code->royalty_gas_rate }}%</div>
                            </div>
                            <div class="col-6">
                                <div style="color: var(--text-muted);">Tranches</div>
                                <div class="fw-bold">{{ $code->tranches_count }}</div>
                            </div>
                            <div class="col-6">
                                <div style="color: var(--text-muted);">Projets</div>
                                <div class="fw-bold">{{ $code->projects_count }}</div>
                            </div>
                        </div>
                    </div>

                    <div style="padding: 0.75rem 1.5rem; border-top: 1px solid var(--border); background: var(--surface-secondary);" class="d-flex gap-2">
                        <a href="{{ route('petroleum-codes.show', $code) }}" class="btn btn-ghost btn-sm flex-fill">
                            <i class="bi bi-eye me-1"></i> Voir
                        </a>
                        <a href="{{ route('petroleum-codes.edit', $code) }}" class="btn btn-ghost btn-sm flex-fill">
                            <i class="bi bi-pencil me-1"></i> Modifier
                        </a>
                        <form action="{{ route('petroleum-codes.duplicate', $code) }}" method="POST" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm w-100">
                                <i class="bi bi-copy me-1"></i> Dupliquer
                            </button>
                        </form>
                        @unless($code->is_system)
                            <form action="{{ route('petroleum-codes.destroy', $code) }}" method="POST" onsubmit="return confirm('Supprimer ce code ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-sm" style="color: var(--danger);">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        @endunless
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card-modern p-5 text-center">
                    <i class="bi bi-journal-code" style="font-size: 2rem; color: var(--text-muted);"></i>
                    <h5 class="fw-bold mt-3">Aucun code petrolier</h5>
                    <p style="color: var(--text-muted);">Lancez le seeder ou creez un nouveau code.</p>
                </div>
            </div>
        @endforelse
    </div>
</x-app-layout>
