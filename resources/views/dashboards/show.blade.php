<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-black text-dark mb-0">{{ $project->name }} <span class="text-primary ms-2">Analytics</span></h2>
                <div class="small fw-bold text-muted text-uppercase tracking-wider mt-1" style="font-size: 0.65rem;">Simulation Id: #{{ $project->id }}</div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('projects.show', $project) }}" class="btn btn-light border fw-bold rounded-3 px-4 py-2">Paramètres</a>
                <form action="{{ route('simulations.run', $project) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary-premium btn-premium shadow">Actualiser les résultats</button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- KPIs Row -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="kpi-card shadow-sm h-100 border-start border-4 border-primary">
                    <p class="xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">VAN (NPV) @ 10%</p>
                    <h3 class="fw-black text-primary mb-0">{{ number_format(count($cumulativeNPV) > 0 ? end($cumulativeNPV) : 0, 2) }} <span class="small opacity-50">M$</span></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card shadow-sm h-100 border-start border-4 border-success">
                    <p class="xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">TRI (IRR)</p>
                    <h3 class="fw-black text-success mb-0">-- <span class="small opacity-50">%</span></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card shadow-sm h-100 border-start border-4 border-info">
                    <p class="xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">Revenue Brut</p>
                    <h3 class="fw-black text-info mb-0">{{ number_format($cashflows->sum('gross_revenue'), 1) }} <span class="small opacity-50">M$</span></h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card shadow-sm h-100 border-start border-4 border-warning">
                    <p class="xsmall fw-black text-muted text-uppercase mb-2" style="font-size: 0.65rem; letter-spacing: 1px;">Part Sénégal</p>
                    <h3 class="fw-black text-warning mb-0">{{ number_format($cashflows->sum('state_share') + $cashflows->sum('petrosen_share'), 1) }} <span class="small opacity-50">M$</span></h3>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-4 mb-5">
            <div class="col-lg-8">
                <div class="card card-premium p-4 shadow-sm border h-100">
                    <h5 class="fw-black text-dark mb-4">Profil de Trésorerie annuel (M$)</h5>
                    <div style="height: 350px;">
                        <canvas id="cashflowChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-premium p-4 shadow-sm border h-100 text-center">
                    <h5 class="fw-black text-dark mb-4">Répartition des Revenus (%)</h5>
                    <div class="d-flex align-items-center justify-content-center" style="height: 250px;">
                        <canvas id="distributionChart"></canvas>
                    </div>
                    <div class="mt-4 text-start">
                        <div class="d-flex justify-content-between mb-2 small fw-bold">
                            <span><span class="badge bg-warning p-1 me-1"></span> Sénégal</span>
                            <span>{{ number_format($cashflows->sum('state_share') + $cashflows->sum('petrosen_share'), 1) }} M$</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2 small fw-bold">
                            <span><span class="badge bg-success p-1 me-1"></span> Opérateur</span>
                            <span>{{ number_format($cashflows->sum('operator_share') - $cashflows->sum('income_tax'), 1) }} M$</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Width Chart -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card card-premium p-4 shadow-sm border">
                    <h5 class="fw-black text-dark mb-4">Évolution de la Valeur Actuelle Nette (VAN Cumulative)</h5>
                    <div style="height: 250px;">
                        <canvas id="npvChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Strategic Table -->
        <div class="card card-premium shadow border-0 overflow-hidden">
            <div class="card-header bg-light p-4 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-black text-dark mb-0">Rapport Stratégique Multi-Annuels</h5>
                <button class="btn btn-white btn-sm border fw-bold">Exporter Excel</button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 table-premium">
                    <thead>
                        <tr>
                            <th class="p-4 border-0">Année</th>
                            <th class="p-4 border-0 text-end">Rev. Brut (M$)</th>
                            <th class="p-4 border-0 text-end">Cost Recovery (M$)</th>
                            <th class="p-4 border-0 text-end">Profit Oil (M$)</th>
                            <th class="p-4 border-0 text-end">Part Sénégal (M$)</th>
                            <th class="p-4 border-0 text-end">VAN Cumulative (M$)</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($cashflows as $index => $cf)
                            <tr>
                                <td class="p-4 border-0 bg-light fw-black text-muted">{{ $cf->year }}</td>
                                <td class="p-4 border-0 text-end fw-bold">{{ number_format($cf->gross_revenue, 1) }}</td>
                                <td class="p-4 border-0 text-end fw-bold text-info">{{ number_format($cf->cost_recovery, 1) }}</td>
                                <td class="p-4 border-0 text-end fw-bold text-success">{{ number_format($cf->profit_oil, 1) }}</td>
                                <td class="p-4 border-0 text-end fw-bold text-warning">{{ number_format($cf->state_share + $cf->petrosen_share, 1) }}</td>
                                <td class="p-4 border-0 text-end fw-bold {{ $cumulativeNPV[$index] < 0 ? 'text-danger' : 'text-primary' }}">{{ number_format($cumulativeNPV[$index], 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);

        // Bootstrap Colors
        const colors = {
            primary: '#2563eb',
            success: '#10b981',
            warning: '#f59e0b',
            info: '#0ea5e9',
            slate: '#64748b'
        };

        // 1. Bar Chart
        new Chart(document.getElementById('cashflowChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Brut', data: @json($revenues), backgroundColor: colors.info, borderRadius: 5 },
                    { label: 'Opérateur', data: @json($netProfits), backgroundColor: colors.success, borderRadius: 5 },
                    { label: 'Sénégal', data: @json($stateShare), backgroundColor: colors.warning, borderRadius: 5 }
                ]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { font: { weight: 'bold', family: 'Outfit' } } } },
                scales: { y: { grid: { borderDash: [5, 5] }, beginAtZero: true } }
            }
        });

        // 2. NPV Chart
        new Chart(document.getElementById('npvChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cumul VAN',
                    data: @json($cumulativeNPV),
                    borderColor: colors.primary,
                    borderWidth: 4,
                    tension: 0.3,
                    fill: true,
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    pointRadius: 4,
                    pointBackgroundColor: '#fff'
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { grid: { borderDash: [5, 5] } } }
            }
        });

        // 3. Doughnut
        new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['Sénégal', 'Opérateur', 'Taxes'],
                datasets: [{
                    data: [
                        {{ $cashflows->sum('state_share') + $cashflows->sum('petrosen_share') }},
                        {{ $cashflows->sum('operator_share') }},
                        {{ $cashflows->sum('income_tax') + $cashflows->sum('royalties') }}
                    ],
                    backgroundColor: [colors.warning, colors.success, colors.primary],
                    borderWidth: 0
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                cutout: '80%',
                plugins: { legend: { display: false } }
            }
        });
    </script>
    @endpush
</x-app-layout>
