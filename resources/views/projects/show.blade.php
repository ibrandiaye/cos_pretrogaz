<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('projects.index') }}" class="btn btn-ghost" style="padding: 0.45rem 0.65rem;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">{{ $project->name }}</h1>
                <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">
                    {{ ucfirst($project->type) }} &middot; Code {{ $project->code_petrolier }} &middot; {{ $project->duration }} ans
                </p>
            </div>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('dashboards.show', $project) }}" class="btn btn-ghost">
            <i class="bi bi-graph-up me-1"></i> Analytics
        </a>
        <form action="{{ route('simulations.run', $project) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-accent">
                <i class="bi bi-lightning-charge-fill me-1"></i> Simuler
            </button>
        </form>
    </x-slot>

    <div x-data="{ tab: 'params' }">
        <!-- Tab Navigation -->
        <div class="tab-nav mb-4 overflow-auto">
            <button @click="tab = 'params'" :class="tab === 'params' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-gear me-1"></i> Parametres
            </button>
            <button @click="tab = 'capex'" :class="tab === 'capex' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-building me-1"></i> CAPEX
            </button>
            <button @click="tab = 'opex'" :class="tab === 'opex' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-tools me-1"></i> OPEX
            </button>
            <button @click="tab = 'prod'" :class="tab === 'prod' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-droplet-half me-1"></i> Production
            </button>
            <button @click="tab = 'prices'" :class="tab === 'prices' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-currency-dollar me-1"></i> Macro
            </button>
        </div>

        <div class="card-modern overflow-hidden">
            <form action="{{ route('projects.update-inputs', $project) }}" method="POST">
                @csrf

                <!-- PARAMS TAB -->
                <div x-show="tab === 'params'" x-transition>
                    <input type="hidden" name="type" value="parameters">

                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface-secondary);">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">
                            <i class="bi bi-gear me-2" style="color: var(--accent);"></i> Parametres Fiscaux & Contractuels
                        </h6>
                    </div>

                    <div class="row g-0" style="padding: 1.5rem;">
                        <!-- Fiscalite -->
                        <div class="col-lg-4" style="padding-right: 1.5rem;">
                            <div class="mb-3 pb-3" style="border-bottom: 2px solid var(--accent); display: inline-block;">
                                <h6 class="fw-bold mb-0" style="font-size: 0.85rem; color: var(--accent);">Fiscalite & Taxes</h6>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">IS (Impot Societe) %</label>
                                <input type="number" step="0.01" name="inputs[0][taux_is]" value="{{ $project->parameter->taux_is }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">TVA %</label>
                                <input type="number" step="0.01" name="inputs[0][tva]" value="{{ $project->parameter->tva }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">CEL %</label>
                                <input type="number" step="0.01" name="inputs[0][cel]" value="{{ $project->parameter->cel }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Taxe Export %</label>
                                <input type="number" step="0.01" name="inputs[0][taxe_export]" value="{{ $project->parameter->taxe_export }}"
                                    class="form-control form-modern">
                            </div>
                        </div>

                        <!-- Contrat -->
                        <div class="col-lg-4" style="padding: 0 1.5rem; border-left: 1px solid var(--border-light); border-right: 1px solid var(--border-light);">
                            <div class="mb-3 pb-3" style="border-bottom: 2px solid var(--success); display: inline-block;">
                                <h6 class="fw-bold mb-0" style="font-size: 0.85rem; color: var(--success);">Contrat & Redevances</h6>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Redevance Petrole %</label>
                                <input type="number" step="0.01" name="inputs[0][redevance_petrole]" value="{{ $project->parameter->redevance_petrole }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Redevance Gaz %</label>
                                <input type="number" step="0.01" name="inputs[0][redevance_gaz]" value="{{ $project->parameter->redevance_gaz }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Plafond Cost Recovery %</label>
                                <input type="number" step="0.01" name="inputs[0][cost_recovery_ceiling]" value="{{ $project->parameter->cost_recovery_ceiling }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Bonus Signature ($)</label>
                                <input type="number" step="0.01" name="inputs[0][bonus_signature]" value="{{ $project->parameter->bonus_signature }}"
                                    class="form-control form-modern">
                            </div>
                        </div>

                        <!-- Participations -->
                        <div class="col-lg-4" style="padding-left: 1.5rem;">
                            <div class="mb-3 pb-3" style="border-bottom: 2px solid #7c3aed; display: inline-block;">
                                <h6 class="fw-bold mb-0" style="font-size: 0.85rem; color: #7c3aed;">Participations</h6>
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Part PETROSEN %</label>
                                <input type="number" step="0.01" name="inputs[0][petrosen_participation]" value="{{ $project->parameter->petrosen_participation }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Part Etat (Carried Interest) %</label>
                                <input type="number" step="0.01" name="inputs[0][state_participation]" value="{{ $project->parameter->state_participation }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Discount Rate (VAN) %</label>
                                <input type="number" step="0.01" name="inputs[0][discount_rate]" value="{{ $project->parameter->discount_rate }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Taxe Carbone ($/tonne)</label>
                                <input type="number" step="0.01" name="inputs[0][taxe_carbone]" value="{{ $project->parameter->taxe_carbone }}"
                                    class="form-control form-modern">
                            </div>
                        </div>
                    </div>

                    <!-- PETROSEN Loan Section -->
                    <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); background: var(--surface-secondary);">
                        <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">
                            <i class="bi bi-bank me-2" style="color: var(--warning);"></i> Financement PETROSEN
                        </h6>
                    </div>
                    <div class="row" style="padding: 1.5rem;">
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Montant Pret ($)</label>
                            <input type="number" step="0.01" name="inputs[0][petrosen_loan_amount]" value="{{ $project->parameter->petrosen_loan_amount }}"
                                class="form-control form-modern">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Taux Interet %</label>
                            <input type="number" step="0.01" name="inputs[0][petrosen_interest_rate]" value="{{ $project->parameter->petrosen_interest_rate }}"
                                class="form-control form-modern">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Grace (annees)</label>
                            <input type="number" name="inputs[0][petrosen_grace_period]" value="{{ $project->parameter->petrosen_grace_period }}"
                                class="form-control form-modern">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Maturite (annees)</label>
                            <input type="number" name="inputs[0][petrosen_maturity]" value="{{ $project->parameter->petrosen_maturity }}"
                                class="form-control form-modern">
                        </div>
                    </div>
                </div>

                <!-- DYNAMIC DATA TABS -->
                @php
                    $tabConfigs = [
                        'capex' => [
                            'label' => 'Investissements (CAPEX)',
                            'icon' => 'bi-building',
                            'color' => 'var(--accent)',
                            'collection' => 'capexes',
                            'fields' => [
                                'exploration' => ['label' => 'Exploration (M$)', 'step' => '0.01'],
                                'development' => ['label' => 'Developpement (M$)', 'step' => '0.01'],
                                'pipeline_fpso' => ['label' => 'Pipeline/FPSO (M$)', 'step' => '0.01'],
                                'installations' => ['label' => 'Installations (M$)', 'step' => '0.01'],
                                'divers' => ['label' => 'Divers (M$)', 'step' => '0.01'],
                            ]
                        ],
                        'opex' => [
                            'label' => 'Exploitation (OPEX)',
                            'icon' => 'bi-tools',
                            'color' => 'var(--success)',
                            'collection' => 'opexes',
                            'fields' => [
                                'exploitation' => ['label' => 'Exploitation (M$)', 'step' => '0.01'],
                                'maintenance' => ['label' => 'Maintenance (M$)', 'step' => '0.01'],
                                'location' => ['label' => 'Location (M$)', 'step' => '0.01'],
                            ]
                        ],
                        'prod' => [
                            'label' => 'Production',
                            'icon' => 'bi-droplet-half',
                            'color' => 'var(--warning)',
                            'collection' => 'productions',
                            'fields' => [
                                'oil' => ['label' => 'Petrole (Mbbl)', 'step' => '0.001'],
                                'gas' => ['label' => 'Gaz (Bcf)', 'step' => '0.001'],
                                'gnl' => ['label' => 'GNL (MT)', 'step' => '0.001'],
                            ]
                        ],
                        'prices' => [
                            'label' => 'Macro-economie',
                            'icon' => 'bi-currency-dollar',
                            'color' => '#7c3aed',
                            'collection' => 'prices',
                            'fields' => [
                                'oil_price' => ['label' => 'Brent ($/bbl)', 'step' => '0.01'],
                                'gas_price' => ['label' => 'Gaz ($/MMBTU)', 'step' => '0.01'],
                                'gnl_price' => ['label' => 'GNL ($/MMBTU)', 'step' => '0.01'],
                                'inflation' => ['label' => 'Inflation %', 'step' => '0.01'],
                                'exchange_rate' => ['label' => 'FCFA/USD', 'step' => '0.0001'],
                            ]
                        ],
                    ];
                @endphp

                @foreach($tabConfigs as $tabKey => $config)
                <div x-show="tab === '{{ $tabKey }}'" x-transition>
                    <input type="hidden" name="type" value="{{ $tabKey === 'prod' ? 'production' : ($tabKey === 'prices' ? 'price' : $tabKey) }}">

                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); background: var(--surface-secondary);">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">
                            <i class="bi {{ $config['icon'] }} me-2" style="color: {{ $config['color'] }};"></i> {{ $config['label'] }}
                        </h6>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">Annee</th>
                                    @foreach($config['fields'] as $field => $fieldConfig)
                                        <th class="text-end">{{ $fieldConfig['label'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @for($y = 1; $y <= $project->duration; $y++)
                                    @php $item = $project->{$config['collection']}->firstWhere('year', $y); @endphp
                                    <tr>
                                        <td>
                                            <span class="badge-modern badge-blue">{{ $y }}</span>
                                        </td>
                                        @foreach($config['fields'] as $field => $fieldConfig)
                                            <td class="text-end">
                                                <input type="number" step="{{ $fieldConfig['step'] }}"
                                                    name="inputs[{{ $y }}][{{ $field }}]"
                                                    value="{{ $item->$field ?? 0 }}"
                                                    class="form-control form-modern text-end"
                                                    style="max-width: 140px; display: inline-block; padding: 0.4rem 0.6rem; font-size: 0.85rem;">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach

                <!-- Footer -->
                <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); background: var(--surface-secondary);" class="d-flex justify-content-between align-items-center">
                    <p class="mb-0" style="font-size: 0.8rem; color: var(--text-muted);">
                        <i class="bi bi-info-circle me-1"></i> Sauvegardez puis lancez la simulation pour actualiser les calculs
                    </p>
                    <button type="submit" class="btn btn-accent">
                        <i class="bi bi-check-lg me-1"></i> Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
