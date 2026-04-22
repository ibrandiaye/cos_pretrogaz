<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('projects.index') }}" class="btn btn-ghost" style="padding: 0.45rem 0.65rem;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">{{ $project->name }}</h1>
                <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">
                    {{ ucfirst($project->type) }} &middot; {{ $project->petroleumCode?->name ?? 'Code ' . $project->code_petrolier }} &middot; {{ $project->duration }} ans
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
            <button @click="tab = 'abex'" :class="tab === 'abex' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-x-octagon me-1"></i> ABEX
            </button>
            <button @click="tab = 'prod'" :class="tab === 'prod' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-droplet-half me-1"></i> Production
            </button>
            <button @click="tab = 'prices'" :class="tab === 'prices' ? 'tab-btn active' : 'tab-btn'">
                <i class="bi bi-currency-dollar me-1"></i> Macro
            </button>
        </div>

        <div class="card-modern overflow-hidden">
                <!-- PARAMS TAB -->
                <div x-show="tab === 'params'" x-transition>
                    <form action="{{ route('projects.update-inputs', $project) }}" method="POST">
                    @csrf
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
                            <div class="mb-3">
                                <label class="form-label-modern">WHT Dividendes %</label>
                                <input type="number" step="0.01" name="inputs[0][wht_dividendes]" value="{{ $project->parameter->wht_dividendes }}"
                                    class="form-control form-modern">
                            </div>
                            <div class="mb-3">
                                <label class="form-label-modern">Business License Tax %</label>
                                <input type="number" step="0.0001" name="inputs[0][business_license_tax]" value="{{ $project->parameter->business_license_tax }}"
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
                                <label class="form-label-modern">Type de Bloc</label>
                                <select name="inputs[0][bloc_type]" class="form-control form-modern">
                                    <option value="onshore" {{ $project->parameter->bloc_type === 'onshore' ? 'selected' : '' }}>Onshore</option>
                                    <option value="offshore_peu_profond" {{ $project->parameter->bloc_type === 'offshore_peu_profond' ? 'selected' : '' }}>Offshore Peu Profond</option>
                                    <option value="offshore_profond" {{ $project->parameter->bloc_type === 'offshore_profond' ? 'selected' : '' }}>Offshore Profond</option>
                                    <option value="offshore_ultra_profond" {{ $project->parameter->bloc_type === 'offshore_ultra_profond' ? 'selected' : '' }}>Offshore Ultra Profond</option>
                                </select>
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

                    <!-- Depreciation & NOL Section -->
                    <div style="padding: 1.25rem 1.5rem; border-top: 1px solid var(--border); background: var(--surface-secondary);">
                        <h6 class="fw-bold mb-0" style="font-size: 0.85rem;">
                            <i class="bi bi-calculator me-2" style="color: var(--info);"></i> Amortissement & Report de Pertes
                        </h6>
                    </div>
                    <div class="row" style="padding: 1.5rem;">
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Amort. Exploration (ans)</label>
                            <input type="number" name="inputs[0][depreciation_exploration]" value="{{ $project->parameter->depreciation_exploration ?? 1 }}"
                                class="form-control form-modern">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Amort. Installations (ans)</label>
                            <input type="number" name="inputs[0][depreciation_installations]" value="{{ $project->parameter->depreciation_installations ?? 5 }}"
                                class="form-control form-modern">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Amort. Pipeline/FPSO (ans)</label>
                            <input type="number" name="inputs[0][depreciation_pipeline_fpso]" value="{{ $project->parameter->depreciation_pipeline_fpso ?? 10 }}"
                                class="form-control form-modern">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label-modern">Report pertes NOL (ans)</label>
                            <input type="number" name="inputs[0][nol_years]" value="{{ $project->parameter->nol_years ?? 3 }}"
                                class="form-control form-modern">
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

                    <!-- Footer Params -->
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

                <!-- DYNAMIC DATA TABS -->
                @php
                    $tabConfigs = [
                        'capex' => [
                            'label' => 'Investissements (CAPEX)',
                            'icon' => 'bi-building',
                            'color' => 'var(--accent)',
                            'collection' => 'capexes',
                            'has_inflation' => true,
                            'fields' => [
                                'exploration' => ['label' => 'Exploration (M$)', 'step' => '0.01'],
                                'etudes_pre_fid' => ['label' => 'Etudes Pre-FID (M$)', 'step' => '0.01'],
                                'forage_completion' => ['label' => 'Forage & Completion (M$)', 'step' => '0.01'],
                                'installations_sous_marines' => ['label' => 'Inst. Sous-Marines (M$)', 'step' => '0.01'],
                                'pipeline' => ['label' => 'Pipeline(s) (M$)', 'step' => '0.01'],
                                'installations_surface' => ['label' => 'Inst. Surface (M$)', 'step' => '0.01'],
                                'owners_cost' => ['label' => 'Owners Cost (M$)', 'step' => '0.01'],
                                'imprevus' => ['label' => 'Imprevus (M$)', 'step' => '0.01'],
                            ]
                        ],
                        'opex' => [
                            'label' => 'Exploitation (OPEX)',
                            'icon' => 'bi-tools',
                            'color' => 'var(--success)',
                            'collection' => 'opexes',
                            'has_inflation' => true,
                            'fields' => [
                                'location_flng' => ['label' => 'Location FLNG (M$)', 'step' => '0.01'],
                                'location_fpso' => ['label' => 'Location FPSO (M$)', 'step' => '0.01'],
                                'opex_puits' => ['label' => 'Opex Puits (M$)', 'step' => '0.01'],
                                'maintenance_installations' => ['label' => 'Maintenance Inst. (M$)', 'step' => '0.01'],
                                'autres_opex' => ['label' => 'Autres Opex (M$)', 'step' => '0.01'],
                            ]
                        ],
                        'abex' => [
                            'label' => 'Abandon (ABEX)',
                            'icon' => 'bi-x-octagon',
                            'color' => '#dc3545',
                            'collection' => 'abexes',
                            'has_inflation' => true,
                            'fields' => [
                                'cout_abandon' => ['label' => 'Cout Abandon (M$)', 'step' => '0.01'],
                            ]
                        ],
                        'prod' => [
                            'label' => 'Production',
                            'icon' => 'bi-droplet-half',
                            'color' => 'var(--warning)',
                            'collection' => 'productions',
                            'has_production_computed' => true,
                            'fields' => [
                                'petrole_jour' => ['label' => 'Petrole (mbbl/j)', 'step' => '0.0001'],
                                'gaz_domestique_jour' => ['label' => 'Gaz Dom. (mmscf/j)', 'step' => '0.0001'],
                                'gnl_jour' => ['label' => 'GNL (mmscf/j)', 'step' => '0.0001'],
                                'gaz_combustible_pertes' => ['label' => 'Gaz Comb./Pertes (mmscf/j)', 'step' => '0.0001'],
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
                @php
                    $hasInflation = !empty($config['has_inflation']);
                    $hasProdComputed = !empty($config['has_production_computed']);
                    $fieldKeys = array_keys($config['fields']);
                    // Build initial data for Alpine
                    $rowsInit = [];
                    for ($y = 1; $y <= $project->duration; $y++) {
                        $item = $project->{$config['collection']}->firstWhere('year', $y);
                        $priceRow = $project->prices->firstWhere('year', $y);
                        $row = ['year' => $y, 'rate' => $priceRow ? (float) $priceRow->inflation / 100 : 0];
                        foreach ($fieldKeys as $f) {
                            $row[$f] = $item ? (float) $item->$f : 0;
                        }
                        $rowsInit[] = $row;
                    }
                @endphp
                <div x-show="tab === '{{ $tabKey }}'" x-transition>
                    <form action="{{ route('projects.update-inputs', $project) }}" method="POST"
                          x-data="{
                              rows: {{ json_encode($rowsInit) }},
                              fields: {{ json_encode($fieldKeys) }},
                              hasInflation: {{ $hasInflation ? 'true' : 'false' }},
                              hasProd: {{ $hasProdComputed ? 'true' : 'false' }},
                              // Constantes de conversion (Excel)
                              BOE: 5.8, LNG_CONV: 142.008197, GAS_LNG: 1006.873, GAS_DOM: 1065,
                              // Inflation computed
                              rowTotal(i) {
                                  let s = 0;
                                  for (const f of this.fields) s += parseFloat(this.rows[i][f]) || 0;
                                  return s;
                              },
                              rowInflation(i) { return this.rowTotal(i) * (this.rows[i].rate || 0); },
                              rowTotalAvec(i) { return this.rowTotal(i) + this.rowInflation(i); },
                              grandTotal() { let s=0; for(let i=0;i<this.rows.length;i++) s+=this.rowTotal(i); return s; },
                              grandInflation() { let s=0; for(let i=0;i<this.rows.length;i++) s+=this.rowInflation(i); return s; },
                              grandTotalAvec() { let s=0; for(let i=0;i<this.rows.length;i++) s+=this.rowTotalAvec(i); return s; },
                              // Production computed
                              petroleAn(i) { return (this.rows[i].petrole_jour||0) * 365 / 1000; },
                              gazDomTbtu(i) { return (this.rows[i].gaz_domestique_jour||0) * 365 * this.GAS_DOM / 1e6; },
                              gnlMtpa(i) { return (this.rows[i].gnl_jour||0) / this.LNG_CONV; },
                              gnlTbtu(i) { return (this.rows[i].gnl_jour||0) * 365 * this.GAS_LNG / 1e6; },
                              totalGazJour(i) { return (this.rows[i].gaz_domestique_jour||0) + (this.rows[i].gnl_jour||0) + (this.rows[i].gaz_combustible_pertes||0); },
                              totalEquivPetrole(i) { return (this.rows[i].petrole_jour||0) + this.totalGazJour(i) / this.BOE; },
                              totalEquivHorsPertes(i) { return (this.rows[i].petrole_jour||0) + ((this.rows[i].gaz_domestique_jour||0) + (this.rows[i].gnl_jour||0)) / this.BOE; },
                              fmt(v) { return v.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}); },
                              fmt4(v) { return v.toLocaleString('fr-FR', {minimumFractionDigits: 4, maximumFractionDigits: 4}); }
                          }">
                    @csrf
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
                                    @if($hasInflation)
                                        <th class="text-end">Inflation (%)</th>
                                    @endif
                                    @foreach($config['fields'] as $field => $fieldConfig)
                                        <th class="text-end">{{ $fieldConfig['label'] }}</th>
                                    @endforeach
                                    @if($hasInflation)
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Total hors infl. (M$)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Inflation (M$)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Total avec infl. (M$)</th>
                                    @endif
                                    @if($hasProdComputed)
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Petrole (mmbbls/an)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Gaz Dom. (Tbtu/an)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">GNL (MTPA)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">GNL (Tbtu/an)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Total Gaz (mmscf/j)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Equiv. Petrole (mbbl/j)</th>
                                        <th class="text-end" style="background: var(--surface-secondary); font-weight: 700;">Equiv. hors pertes (mbbl/j)</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(row, i) in rows" :key="row.year">
                                    <tr>
                                        <td>
                                            <span class="badge-modern badge-blue" x-text="row.year"></span>
                                        </td>
                                        @if($hasInflation)
                                            <td class="text-end">
                                                <span style="font-size: 0.85rem; color: var(--text-muted);" x-text="(row.rate * 100).toFixed(1) + '%'"></span>
                                            </td>
                                        @endif
                                        @foreach($config['fields'] as $idx => $field)
                                            @php $fieldName = $idx; @endphp
                                            <td class="text-end">
                                                <input type="number" step="{{ $field['step'] }}"
                                                    x-model.number="row.{{ $fieldName }}"
                                                    :name="'inputs[' + row.year + '][{{ $fieldName }}]'"
                                                    class="form-control form-modern text-end"
                                                    style="max-width: 140px; display: inline-block; padding: 0.4rem 0.6rem; font-size: 0.85rem;">
                                            </td>
                                        @endforeach
                                        @if($hasInflation)
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <strong style="font-size: 0.85rem;" x-text="fmt(rowTotal(i))"></strong>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <span style="font-size: 0.85rem; color: var(--text-muted);" x-text="fmt(rowInflation(i))"></span>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <strong style="font-size: 0.85rem; color: {{ $config['color'] }};" x-text="fmt(rowTotalAvec(i))"></strong>
                                            </td>
                                        @endif
                                        @if($hasProdComputed)
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <strong style="font-size: 0.85rem;" x-text="fmt4(petroleAn(i))"></strong>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <span style="font-size: 0.85rem;" x-text="fmt(gazDomTbtu(i))"></span>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <span style="font-size: 0.85rem;" x-text="fmt4(gnlMtpa(i))"></span>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <span style="font-size: 0.85rem;" x-text="fmt(gnlTbtu(i))"></span>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <strong style="font-size: 0.85rem; color: var(--warning);" x-text="fmt(totalGazJour(i))"></strong>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <strong style="font-size: 0.85rem; color: var(--accent);" x-text="fmt(totalEquivPetrole(i))"></strong>
                                            </td>
                                            <td class="text-end" style="background: var(--surface-secondary);">
                                                <strong style="font-size: 0.85rem; color: var(--success);" x-text="fmt(totalEquivHorsPertes(i))"></strong>
                                            </td>
                                        @endif
                                    </tr>
                                </template>
                            </tbody>
                            @if($hasInflation)
                                <tfoot>
                                    <tr style="border-top: 2px solid var(--border); background: var(--surface-secondary);">
                                        <td><strong>Total</strong></td>
                                        <td></td>
                                        @foreach($config['fields'] as $field => $fieldConfig)
                                            <td></td>
                                        @endforeach
                                        <td class="text-end" style="background: var(--surface-secondary);">
                                            <strong style="font-size: 0.9rem;" x-text="fmt(grandTotal())"></strong>
                                        </td>
                                        <td class="text-end" style="background: var(--surface-secondary);">
                                            <strong style="font-size: 0.9rem; color: var(--text-muted);" x-text="fmt(grandInflation())"></strong>
                                        </td>
                                        <td class="text-end" style="background: var(--surface-secondary);">
                                            <strong style="font-size: 0.9rem; color: {{ $config['color'] }};" x-text="fmt(grandTotalAvec())"></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            @endif
                        </table>
                    </div>

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
                @endforeach
        </div>
    </div>
</x-app-layout>
