<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <a href="{{ route('projects.index') }}" class="btn btn-light border p-2 rounded-3 me-3">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <div>
                    <h2 class="fw-black text-dark mb-0">{{ $project->name }}</h2>
                    <p class="text-muted small mb-0">{{ ucfirst($project->type) }} / Code {{ $project->code_petrolier }}</p>
                </div>
            </div>
            <div class="d-flex gap-3">
                <form action="{{ route('simulations.run', $project) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary-premium btn-premium shadow d-flex align-items-center">
                        <svg class="me-2" width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path></svg>
                        Simuler
                    </button>
                </form>
                <a href="{{ route('dashboards.show', $project) }}" class="btn btn-dark btn-premium">Consulter Analytics</a>
            </div>
        </div>
    </x-slot>

    <div class="py-4" x-data="{ tab: 'params' }">
        <!-- Navigation Onglets Bootstrap Styles -->
        <div class="bg-white p-2 rounded-4 border shadow-sm mb-4 d-flex gap-2 overflow-auto">
            <button @click="tab = 'params'" :class="tab === 'params' ? 'btn btn-primary shadow-sm' : 'btn btn-light text-muted border-0'" class="fw-bold px-4 py-3 rounded-3 flex-shrink-0">Paramètres</button>
            <button @click="tab = 'capex'" :class="tab === 'capex' ? 'btn btn-primary shadow-sm' : 'btn btn-light text-muted border-0'" class="fw-bold px-4 py-3 rounded-3 flex-shrink-0">Investissements (CAPEX)</button>
            <button @click="tab = 'opex'" :class="tab === 'opex' ? 'btn btn-primary shadow-sm' : 'btn btn-light text-muted border-0'" class="fw-bold px-4 py-3 rounded-3 flex-shrink-0">Exploitation (OPEX)</button>
            <button @click="tab = 'prod'" :class="tab === 'prod' ? 'btn btn-primary shadow-sm' : 'btn btn-light text-muted border-0'" class="fw-bold px-4 py-3 rounded-3 flex-shrink-0">Production</button>
            <button @click="tab = 'prices'" :class="tab === 'prices' ? 'btn btn-primary shadow-sm' : 'btn btn-light text-muted border-0'" class="fw-bold px-4 py-3 rounded-3 flex-shrink-0">Macro-économie</button>
        </div>

        <div class="card card-premium p-4 shadow-sm border">
            <form action="{{ route('projects.update-inputs', $project) }}" method="POST">
                @csrf
                
                <!-- PARAMS TAB -->
                <div x-show="tab === 'params'">
                    <input type="hidden" name="type" value="parameters">
                    <div class="row g-5 p-3">
                        <div class="col-lg-4">
                            <h5 class="fw-black text-dark border-bottom pb-3 mb-4">Fiscalité & Taxes</h5>
                            <div class="mb-4">
                                <label class="form-label xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem;">IS (Impôt Société) %</label>
                                <input type="number" step="0.01" name="inputs[0][taux_is]" value="{{ $project->parameter->taux_is }}" class="form-control form-control-lg bg-light border-0 fw-bold py-3 px-4 rounded-4">
                            </div>
                            <div class="mb-4">
                                <label class="form-label xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem;">TVA %</label>
                                <input type="number" step="0.01" name="inputs[0][tva]" value="{{ $project->parameter->tva }}" class="form-control form-control-lg bg-light border-0 fw-bold py-3 px-4 rounded-4">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="fw-black text-dark border-bottom pb-3 mb-4">Contrat</h5>
                            <div class="mb-4">
                                <label class="form-label xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem;">Redevance Pétrole %</label>
                                <input type="number" step="0.01" name="inputs[0][redevance_petrole]" value="{{ $project->parameter->redevance_petrole }}" class="form-control form-control-lg bg-light border-0 fw-bold py-3 px-4 rounded-4">
                            </div>
                            <div class="mb-4">
                                <label class="form-label xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem;">Plafond Cost Recov. %</label>
                                <input type="number" step="0.01" name="inputs[0][cost_recovery_ceiling]" value="{{ $project->parameter->cost_recovery_ceiling }}" class="form-control form-control-lg bg-light border-0 fw-bold py-3 px-4 rounded-4">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <h5 class="fw-black text-dark border-bottom pb-3 mb-4">Participations</h5>
                            <div class="mb-4">
                                <label class="form-label xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem;">Part PETROSEN %</label>
                                <input type="number" step="0.01" name="inputs[0][petrosen_participation]" value="{{ $project->parameter->petrosen_participation }}" class="form-control form-control-lg bg-light border-0 fw-bold py-3 px-4 rounded-4">
                            </div>
                            <div class="mb-4">
                                <label class="form-label xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem;">Discount Rate (VAN) %</label>
                                <input type="number" step="0.01" name="inputs[0][discount_rate]" value="{{ $project->parameter->discount_rate }}" class="form-control form-control-lg bg-light border-0 fw-bold py-3 px-4 rounded-4">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DYNAMIC TABS -->
                <div x-show="['capex', 'opex', 'prod', 'prices'].includes(tab)">
                    <input type="hidden" name="type" :value="tab">
                    <div class="table-responsive rounded-4 border">
                        <table class="table table-hover align-middle mb-0 table-premium">
                            <thead class="bg-light">
                                <tr>
                                    <th class="p-4 border-0">Année</th>
                                    <template x-if="tab === 'capex'">
                                        <th class="p-4 border-0">Exploration (M$)</th><th class="p-4 border-0">Développement (M$)</th><th class="p-4 border-0">Unités Prod (M$)</th><th class="p-4 border-0">Divers (M$)</th>
                                    </template>
                                    <template x-if="tab === 'opex'">
                                        <th class="p-4 border-0">Exploitation (M$)</th><th class="p-4 border-0">Maintenance (M$)</th><th class="p-4 border-0">Location (M$)</th>
                                    </template>
                                    <template x-if="tab === 'prod'">
                                        <th class="p-4 border-0">Pétrole (Mbbl)</th><th class="p-4 border-0">Gaz (Bcf)</th><th class="p-4 border-0">LNG (MT)</th>
                                    </template>
                                    <template x-if="tab === 'prices'">
                                        <th class="p-4 border-0">Brent ($)</th><th class="p-4 border-0">Gaz ($)</th><th class="p-4 border-0">LNG ($)</th><th class="p-4 border-0">Inflation %</th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody>
                                @for($y = 1; $y <= $project->duration; $y++)
                                    <tr>
                                        <td class="p-4 border-0 bg-light fw-black text-muted">{{ $y }}</td>
                                        <template x-if="tab === 'capex'">
                                            @php $item = $project->capexes->firstWhere('year', $y); @endphp
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][exploration]" value="{{ $item->exploration }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][development]" value="{{ $item->development }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][pipeline_fpso]" value="{{ $item->pipeline_fpso }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][divers]" value="{{ $item->divers }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                        </template>
                                        <template x-if="tab === 'opex'">
                                            @php $item = $project->opexes->firstWhere('year', $y); @endphp
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][exploitation]" value="{{ $item->exploitation }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][maintenance]" value="{{ $item->maintenance }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][location]" value="{{ $item->location }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                        </template>
                                        <template x-if="tab === 'prod'">
                                            @php $item = $project->productions->firstWhere('year', $y); @endphp
                                            <td class="p-2 border-0"><input type="number" step="0.001" name="inputs[{{$y}}][oil]" value="{{ $item->oil }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.001" name="inputs[{{$y}}][gas]" value="{{ $item->gas }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.001" name="inputs[{{$y}}][gnl]" value="{{ $item->gnl }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                        </template>
                                        <template x-if="tab === 'prices'">
                                            @php $item = $project->prices->firstWhere('year', $y); @endphp
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][oil_price]" value="{{ $item->oil_price }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][gas_price]" value="{{ $item->gas_price }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][gnl_price]" value="{{ $item->gnl_price }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                            <td class="p-2 border-0"><input type="number" step="0.01" name="inputs[{{$y}}][inflation]" value="{{ $item->inflation }}" class="form-control border-0 bg-transparent fw-bold shadow-none"></td>
                                        </template>
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-5 border-top pt-4 d-flex justify-content-between align-items-center">
                    <p class="text-muted small italic mb-0">Note : L'actualisation des calculs nécessite de "Lancer la Simulation" après avoir sauvegardé vos données.</p>
                    <button type="submit" class="btn btn-primary-premium btn-premium px-5 py-3 shadow">Sauvegarder l'onglet</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
