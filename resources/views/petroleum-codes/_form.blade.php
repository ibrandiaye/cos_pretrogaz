@php $code = $code ?? null; @endphp

<div x-data="{
    method: '{{ old('profit_split_method', $code?->profit_split_method ?? 'r_factor') }}',
    tranches: {{ json_encode(old('tranches', $code?->tranches?->map(fn($t) => ['threshold_max' => $t->threshold_max, 'state_share' => $t->state_share, 'contractor_share' => $t->contractor_share])->toArray() ?? [['threshold_max' => '', 'state_share' => '', 'contractor_share' => '']])) }},
    addTranche() { this.tranches.push({threshold_max: '', state_share: '', contractor_share: ''}); },
    removeTranche(i) { if (this.tranches.length > 1) this.tranches.splice(i, 1); },
    syncContractor(i) { this.tranches[i].contractor_share = Math.max(0, 100 - this.tranches[i].state_share); }
}">
    <div class="row g-4">
        <!-- General Info -->
        <div class="col-md-6">
            <label class="form-label-modern">Nom du Code</label>
            <input type="text" name="name" required value="{{ old('name', $code?->name) }}" placeholder="Ex: Code Petrolier 2025"
                class="form-control form-modern">
        </div>
        <div class="col-md-3">
            <label class="form-label-modern">Identifiant Court</label>
            <input type="text" name="short_name" required value="{{ old('short_name', $code?->short_name) }}" placeholder="Ex: 2025"
                class="form-control form-modern" {{ $code?->is_system ? 'readonly' : '' }}>
        </div>
        <div class="col-md-3">
            <label class="form-label-modern">Methode de Partage</label>
            <select name="profit_split_method" x-model="method" class="form-select form-modern">
                <option value="r_factor">R-Factor</option>
                <option value="production">Production (bbl/jour)</option>
            </select>
        </div>
        <div class="col-12">
            <label class="form-label-modern">Description <span style="font-weight: 400; color: var(--text-muted);">(optionnel)</span></label>
            <textarea name="description" rows="2" class="form-control form-modern" placeholder="Base legale, contexte...">{{ old('description', $code?->description) }}</textarea>
        </div>
    </div>

    <!-- Royalties -->
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
        <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: var(--accent);">
            <i class="bi bi-percent me-2"></i> Redevances (Royalties)
        </h6>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label-modern">Redevance Gaz (%)</label>
                <input type="number" step="0.01" name="royalty_gas_rate" value="{{ old('royalty_gas_rate', $code?->royalty_gas_rate ?? 6) }}" class="form-control form-modern" style="max-width: 200px;">
            </div>
            <div class="col-12"><label class="form-label-modern">Redevance Petrole par type de bloc (%)</label></div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Onshore</label>
                <input type="number" step="0.01" name="royalty_oil_onshore" value="{{ old('royalty_oil_onshore', $code?->royalty_oil_rates['onshore'] ?? 10) }}" class="form-control form-modern">
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Offshore Peu Profond</label>
                <input type="number" step="0.01" name="royalty_oil_offshore_peu_profond" value="{{ old('royalty_oil_offshore_peu_profond', $code?->royalty_oil_rates['offshore_peu_profond'] ?? 9) }}" class="form-control form-modern">
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Offshore Profond</label>
                <input type="number" step="0.01" name="royalty_oil_offshore_profond" value="{{ old('royalty_oil_offshore_profond', $code?->royalty_oil_rates['offshore_profond'] ?? 8) }}" class="form-control form-modern">
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Offshore Ultra Profond</label>
                <input type="number" step="0.01" name="royalty_oil_offshore_ultra_profond" value="{{ old('royalty_oil_offshore_ultra_profond', $code?->royalty_oil_rates['offshore_ultra_profond'] ?? 7) }}" class="form-control form-modern">
            </div>
        </div>
    </div>

    <!-- Cost Recovery Ceilings -->
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
        <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: var(--success);">
            <i class="bi bi-arrow-repeat me-2"></i> Plafonds Cost Recovery (%)
        </h6>
        <div class="row g-3">
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Onshore</label>
                <input type="number" step="0.01" name="cr_onshore" value="{{ old('cr_onshore', $code?->cost_recovery_ceilings['onshore'] ?? 55) }}" class="form-control form-modern">
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Offshore Peu Profond</label>
                <input type="number" step="0.01" name="cr_offshore_peu_profond" value="{{ old('cr_offshore_peu_profond', $code?->cost_recovery_ceilings['offshore_peu_profond'] ?? 60) }}" class="form-control form-modern">
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Offshore Profond</label>
                <input type="number" step="0.01" name="cr_offshore_profond" value="{{ old('cr_offshore_profond', $code?->cost_recovery_ceilings['offshore_profond'] ?? 65) }}" class="form-control form-modern">
            </div>
            <div class="col-md-3">
                <label style="font-size: 0.75rem; color: var(--text-muted);">Offshore Ultra Profond</label>
                <input type="number" step="0.01" name="cr_offshore_ultra_profond" value="{{ old('cr_offshore_ultra_profond', $code?->cost_recovery_ceilings['offshore_ultra_profond'] ?? 70) }}" class="form-control form-modern">
            </div>
        </div>
    </div>

    <!-- Tax Rates -->
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
        <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: var(--danger);">
            <i class="bi bi-receipt me-2"></i> Taux de Taxes
        </h6>
        <div class="row g-3">
            <div class="col-md-3 mb-2"><label class="form-label-modern">IS (%)</label><input type="number" step="0.01" name="taux_is" value="{{ old('taux_is', $code?->taux_is ?? 30) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">CEL (%)</label><input type="number" step="0.01" name="cel" value="{{ old('cel', $code?->cel ?? 1) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">Taxe Export (%)</label><input type="number" step="0.01" name="taxe_export" value="{{ old('taxe_export', $code?->taxe_export ?? 0) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">TVA (%)</label><input type="number" step="0.01" name="tva" value="{{ old('tva', $code?->tva ?? 18) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">WHT Dividendes (%)</label><input type="number" step="0.01" name="wht_dividendes" value="{{ old('wht_dividendes', $code?->wht_dividendes ?? 5) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">Business License Tax (%)</label><input type="number" step="0.0001" name="business_license_tax" value="{{ old('business_license_tax', $code?->business_license_tax ?? 0.02) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">Participation PETROSEN (%)</label><input type="number" step="0.01" name="petrosen_participation_default" value="{{ old('petrosen_participation_default', $code?->petrosen_participation_default ?? 10) }}" class="form-control form-modern"></div>
            <div class="col-md-3 mb-2"><label class="form-label-modern">Participation Etat (%)</label><input type="number" step="0.01" name="state_participation_default" value="{{ old('state_participation_default', $code?->state_participation_default ?? 0) }}" class="form-control form-modern"></div>
        </div>
    </div>

    <!-- Depreciation & NOL -->
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
        <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: var(--info);">
            <i class="bi bi-calculator me-2"></i> Amortissement & NOL
        </h6>
        <div class="row g-3">
            <div class="col-md-3"><label class="form-label-modern">Exploration (ans)</label><input type="number" name="depreciation_exploration" value="{{ old('depreciation_exploration', $code?->depreciation_exploration ?? 1) }}" class="form-control form-modern"></div>
            <div class="col-md-3"><label class="form-label-modern">Installations (ans)</label><input type="number" name="depreciation_installations" value="{{ old('depreciation_installations', $code?->depreciation_installations ?? 5) }}" class="form-control form-modern"></div>
            <div class="col-md-3"><label class="form-label-modern">Pipeline/FPSO (ans)</label><input type="number" name="depreciation_pipeline_fpso" value="{{ old('depreciation_pipeline_fpso', $code?->depreciation_pipeline_fpso ?? 10) }}" class="form-control form-modern"></div>
            <div class="col-md-3"><label class="form-label-modern">Report pertes NOL (ans)</label><input type="number" name="nol_years" value="{{ old('nol_years', $code?->nol_years ?? 3) }}" class="form-control form-modern"></div>
        </div>
    </div>

    <!-- Profit Oil Tranches -->
    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0" style="font-size: 0.9rem; color: #7c3aed;">
                <i class="bi bi-layers me-2"></i> Tranches de Partage du Profit Oil
            </h6>
            <button type="button" @click="addTranche()" class="btn btn-ghost btn-sm">
                <i class="bi bi-plus-lg me-1"></i> Ajouter Tranche
            </button>
        </div>

        <div class="mb-2" style="font-size: 0.8rem; color: var(--text-muted);">
            <span x-show="method === 'r_factor'"><i class="bi bi-info-circle me-1"></i> Seuil = valeur du R-Factor. Derniere tranche = seuil tres eleve (ex: 9999999)</span>
            <span x-show="method === 'production'"><i class="bi bi-info-circle me-1"></i> Seuil = production journaliere en bbl/jour. Derniere tranche = seuil tres eleve</span>
        </div>

        <table class="table table-modern mb-0">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>Seuil Max (<span x-text="method === 'r_factor' ? 'R-Factor' : 'bbl/jour'"></span>)</th>
                    <th>Part Etat (%)</th>
                    <th>Part Contractant (%)</th>
                    <th style="width: 60px;"></th>
                </tr>
            </thead>
            <tbody>
                <template x-for="(tranche, i) in tranches" :key="i">
                    <tr>
                        <td><span class="badge-modern badge-blue" x-text="i + 1"></span></td>
                        <td>
                            <input type="number" step="0.0001" :name="'tranches['+i+'][threshold_max]'" x-model="tranche.threshold_max"
                                class="form-control form-modern" style="max-width: 200px;" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" :name="'tranches['+i+'][state_share]'" x-model="tranche.state_share"
                                @input="syncContractor(i)" class="form-control form-modern" style="max-width: 150px;" required>
                        </td>
                        <td>
                            <input type="number" step="0.01" :name="'tranches['+i+'][contractor_share]'" x-model="tranche.contractor_share"
                                class="form-control form-modern" style="max-width: 150px;" required>
                        </td>
                        <td>
                            <button type="button" @click="removeTranche(i)" class="btn btn-ghost btn-sm" style="color: var(--danger);" x-show="tranches.length > 1">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                </template>
            </tbody>
        </table>
    </div>
</div>
