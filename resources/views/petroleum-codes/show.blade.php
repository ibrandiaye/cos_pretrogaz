<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('petroleum-codes.index') }}" class="btn btn-ghost" style="padding: 0.45rem 0.65rem;"><i class="bi bi-arrow-left"></i></a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.35rem;">{{ $petroleumCode->name }}</h1>
                <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">
                    {{ $petroleumCode->short_name }} &middot;
                    {{ $petroleumCode->profit_split_method === 'r_factor' ? 'R-Factor' : 'Production' }}
                    @if($petroleumCode->is_system) &middot; Systeme @endif
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('petroleum-codes.edit', $petroleumCode) }}" class="btn btn-accent">
            <i class="bi bi-pencil me-1"></i> Modifier
        </a>
    </x-slot>

    <div class="row g-3 animate-in">
        @if($petroleumCode->description)
            <div class="col-12">
                <div class="card-modern p-4">
                    <p class="mb-0" style="font-size: 0.9rem; color: var(--text-secondary);">{{ $petroleumCode->description }}</p>
                </div>
            </div>
        @endif

        <!-- Tax Rates -->
        <div class="col-lg-6">
            <div class="card-modern p-4 h-100">
                <h6 class="fw-bold mb-3" style="font-size: 0.9rem;"><i class="bi bi-receipt me-2" style="color: var(--danger);"></i>Fiscalite</h6>
                <table class="table table-modern mb-0">
                    <tr><td>Impot Societes (IS)</td><td class="text-end fw-bold">{{ $petroleumCode->taux_is }}%</td></tr>
                    <tr><td>CEL</td><td class="text-end fw-bold">{{ $petroleumCode->cel }}%</td></tr>
                    <tr><td>Taxe Export</td><td class="text-end fw-bold">{{ $petroleumCode->taxe_export }}%</td></tr>
                    <tr><td>TVA</td><td class="text-end fw-bold">{{ $petroleumCode->tva }}%</td></tr>
                    <tr><td>WHT Dividendes</td><td class="text-end fw-bold">{{ $petroleumCode->wht_dividendes }}%</td></tr>
                    <tr><td>Business License Tax</td><td class="text-end fw-bold">{{ $petroleumCode->business_license_tax }}%</td></tr>
                </table>
            </div>
        </div>

        <!-- Royalties & CR -->
        <div class="col-lg-6">
            <div class="card-modern p-4 h-100">
                <h6 class="fw-bold mb-3" style="font-size: 0.9rem;"><i class="bi bi-percent me-2" style="color: var(--accent);"></i>Redevances & Cost Recovery</h6>
                <table class="table table-modern mb-0">
                    <thead><tr><th>Type de Bloc</th><th class="text-end">Redevance Petrole</th><th class="text-end">Cost Recovery</th></tr></thead>
                    <tbody>
                        @foreach(['onshore' => 'Onshore', 'offshore_peu_profond' => 'Offshore Peu Profond', 'offshore_profond' => 'Offshore Profond', 'offshore_ultra_profond' => 'Offshore Ultra Profond'] as $key => $label)
                            <tr>
                                <td>{{ $label }}</td>
                                <td class="text-end fw-bold">{{ $petroleumCode->royalty_oil_rates[$key] ?? '-' }}%</td>
                                <td class="text-end fw-bold">{{ $petroleumCode->cost_recovery_ceilings[$key] ?? '-' }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr><td class="fw-bold">Redevance Gaz (tous blocs)</td><td class="text-end fw-bold" colspan="2">{{ $petroleumCode->royalty_gas_rate }}%</td></tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Tranches -->
        <div class="col-12">
            <div class="card-modern p-4">
                <h6 class="fw-bold mb-3" style="font-size: 0.9rem;">
                    <i class="bi bi-layers me-2" style="color: #7c3aed;"></i>
                    Tranches de Partage du Profit Oil
                    <span class="badge-modern {{ $petroleumCode->profit_split_method === 'r_factor' ? 'badge-green' : 'badge-amber' }} ms-2">
                        {{ $petroleumCode->profit_split_method === 'r_factor' ? 'Base sur R-Factor' : 'Base sur Production (bbl/jour)' }}
                    </span>
                </h6>
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Seuil Max ({{ $petroleumCode->profit_split_method === 'r_factor' ? 'R-Factor' : 'bbl/jour' }})</th>
                            <th class="text-end">Part Etat</th>
                            <th class="text-end">Part Contractant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($petroleumCode->tranches as $tranche)
                            <tr>
                                <td><span class="badge-modern badge-blue">{{ $tranche->order }}</span></td>
                                <td>{{ $tranche->threshold_max >= 9999999 ? 'Illimite' : number_format($tranche->threshold_max, $petroleumCode->profit_split_method === 'r_factor' ? 1 : 0) }}</td>
                                <td class="text-end fw-bold" style="color: var(--warning);">{{ $tranche->state_share }}%</td>
                                <td class="text-end fw-bold" style="color: var(--success);">{{ $tranche->contractor_share }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Depreciation -->
        <div class="col-lg-6">
            <div class="card-modern p-4">
                <h6 class="fw-bold mb-3" style="font-size: 0.9rem;"><i class="bi bi-calculator me-2" style="color: var(--info);"></i>Amortissement & NOL</h6>
                <table class="table table-modern mb-0">
                    <tr><td>Exploration</td><td class="text-end fw-bold">{{ $petroleumCode->depreciation_exploration }} an(s)</td></tr>
                    <tr><td>Installations</td><td class="text-end fw-bold">{{ $petroleumCode->depreciation_installations }} ans</td></tr>
                    <tr><td>Pipeline/FPSO</td><td class="text-end fw-bold">{{ $petroleumCode->depreciation_pipeline_fpso }} ans</td></tr>
                    <tr><td>Report pertes (NOL)</td><td class="text-end fw-bold">{{ $petroleumCode->nol_years }} ans</td></tr>
                </table>
            </div>
        </div>

        <!-- Participations -->
        <div class="col-lg-6">
            <div class="card-modern p-4">
                <h6 class="fw-bold mb-3" style="font-size: 0.9rem;"><i class="bi bi-people me-2" style="color: #7c3aed;"></i>Participations par defaut</h6>
                <table class="table table-modern mb-0">
                    <tr><td>PETROSEN</td><td class="text-end fw-bold">{{ $petroleumCode->petrosen_participation_default }}%</td></tr>
                    <tr><td>Etat (Carried Interest)</td><td class="text-end fw-bold">{{ $petroleumCode->state_participation_default }}%</td></tr>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
