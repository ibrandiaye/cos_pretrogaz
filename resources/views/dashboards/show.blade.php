<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">
                {{ $project->name }} <span style="color: var(--accent);">&mdash; Analytics</span>
            </h1>
            <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">
                Simulation #{{ $project->id }} &middot; {{ ucfirst($project->type) }} &middot; Code {{ $project->code_petrolier }}
            </p>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('projects.show', $project) }}" class="btn btn-ghost">
            <i class="bi bi-sliders me-1"></i> Parametres
        </a>
        <a href="{{ route('dashboards.state', $project) }}" class="btn btn-ghost">
            <i class="bi bi-bank2 me-1"></i> Vue Etat
        </a>
        <div class="dropdown d-inline">
            <button class="btn btn-ghost dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download me-1"></i> Exporter
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                <li><a class="dropdown-item fw-semibold" href="{{ route('exports.excel', $project) }}"><i class="bi bi-file-earmark-excel me-2 text-success"></i>Excel (.xlsx)</a></li>
                <li><a class="dropdown-item fw-semibold" href="{{ route('exports.pdf', $project) }}"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>PDF</a></li>
            </ul>
        </div>
        <form action="{{ route('simulations.run', $project) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-accent">
                <i class="bi bi-arrow-repeat me-1"></i> Actualiser
            </button>
        </form>
    </x-slot>

    @if($cashflows->isEmpty())
        <div class="card-modern p-5 text-center" style="margin-top: 3rem;">
            <div style="width: 72px; height: 72px; background: #fef3c7; border-radius: var(--radius-xl); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i class="bi bi-lightning-charge" style="font-size: 1.75rem; color: var(--warning);"></i>
            </div>
            <h3 class="fw-bold mb-2" style="font-size: 1.25rem;">Aucune simulation</h3>
            <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 1.5rem; font-size: 0.9rem;">
                Lancez une simulation pour visualiser les resultats economiques de votre projet.
            </p>
            <form action="{{ route('simulations.run', $project) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-accent px-4 py-2">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Lancer la Simulation
                </button>
            </form>
        </div>
    @else
        @php
            $totalRevenue = $cashflows->sum('gross_revenue');
            $totalState = $cashflows->sum('state_share') + $cashflows->sum('petrosen_share');
            $totalOperator = $cashflows->sum('operator_share') - $cashflows->sum('income_tax');
            $totalTaxes = $cashflows->sum('income_tax') + $cashflows->sum('royalties') + $cashflows->sum('cel') + $cashflows->sum('export_tax') + $cashflows->sum('wht_dividendes') + $cashflows->sum('business_license_tax');
            $npvFinal = count($cumulativeNPV) > 0 ? end($cumulativeNPV) : 0;
            $totalCapex = $cashflows->sum('capex_total');
            $totalOpex = $cashflows->sum('opex_total');
        @endphp

        <!-- KPI Row -->
        <div class="row g-3 mb-4 animate-in">
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-blue h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">VAN (NPV)</div>
                            <div class="kpi-value" style="color: var(--accent);">{{ number_format($npvFinal, 1) }}<span class="kpi-unit">M$</span></div>
                        </div>
                        <div class="kpi-icon" style="background: var(--accent-light);"><i class="bi bi-graph-up-arrow" style="color: var(--accent);"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-green h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">TRI (IRR)</div>
                            <div class="kpi-value" style="color: var(--success);">{{ $irr !== null ? number_format($irr, 1) : '--' }}<span class="kpi-unit">%</span></div>
                        </div>
                        <div class="kpi-icon" style="background: #d1fae5;"><i class="bi bi-percent" style="color: var(--success);"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-cyan h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Revenu Brut</div>
                            <div class="kpi-value" style="color: var(--info);">{{ number_format($totalRevenue, 1) }}<span class="kpi-unit">M$</span></div>
                        </div>
                        <div class="kpi-icon" style="background: #cffafe;"><i class="bi bi-cash-stack" style="color: var(--info);"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-amber h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Part Senegal</div>
                            <div class="kpi-value" style="color: var(--warning);">{{ number_format($totalState, 1) }}<span class="kpi-unit">M$</span></div>
                        </div>
                        <div class="kpi-icon" style="background: #fef3c7;"><i class="bi bi-bank" style="color: var(--warning);"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-purple h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Total CAPEX</div>
                            <div class="kpi-value" style="color: #7c3aed;">{{ number_format($totalCapex, 1) }}<span class="kpi-unit">M$</span></div>
                        </div>
                        <div class="kpi-icon" style="background: #ede9fe;"><i class="bi bi-building" style="color: #7c3aed;"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-red h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Total Taxes</div>
                            <div class="kpi-value" style="color: var(--danger);">{{ number_format($totalTaxes, 1) }}<span class="kpi-unit">M$</span></div>
                        </div>
                        <div class="kpi-icon" style="background: #fee2e2;"><i class="bi bi-receipt" style="color: var(--danger);"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row g-3 mb-4">
            <div class="col-xl-8">
                <div class="card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Profil de Tresorerie Annuel</h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge-modern badge-blue">M$</span>
                            <button onclick="exportChartPDF('cashflowChart', 'Profil_Tresorerie')" style="background: #fef2f2; color: #dc2626; border: none; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;" title="Exporter en PDF">
                                <i class="bi bi-filetype-pdf"></i>
                            </button>
                        </div>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="cashflowChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Repartition des Revenus</h6>
                        <button onclick="exportChartPDF('distributionChart', 'Repartition_Revenus')" style="background: #fef2f2; color: #dc2626; border: none; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;" title="Exporter en PDF">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>
                    </div>
                    <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                        <canvas id="distributionChart"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b; display: inline-block;"></span>
                                <span class="fw-semibold">Senegal</span>
                            </div>
                            <span class="fw-bold">{{ number_format($totalState, 1) }} M$</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                <span class="fw-semibold">Operateur</span>
                            </div>
                            <span class="fw-bold">{{ number_format($totalOperator, 1) }} M$</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #3b82f6; display: inline-block;"></span>
                                <span class="fw-semibold">Taxes</span>
                            </div>
                            <span class="fw-bold">{{ number_format($totalTaxes, 1) }} M$</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NPV Chart -->
        <div class="card-modern p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Evolution de la VAN Cumulative</h6>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge-modern {{ $npvFinal >= 0 ? 'badge-green' : 'badge-amber' }}">
                        {{ $npvFinal >= 0 ? 'Projet Rentable' : 'VAN Negative' }}
                    </span>
                    <button onclick="exportChartPDF('npvChart', 'VAN_Cumulative')" style="background: #fef2f2; color: #dc2626; border: none; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;" title="Exporter en PDF">
                        <i class="bi bi-filetype-pdf"></i>
                    </button>
                </div>
            </div>
            <div style="height: 250px;">
                <canvas id="npvChart"></canvas>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="card-modern overflow-hidden">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);" class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">
                    <i class="bi bi-table me-2" style="color: var(--accent);"></i> Rapport Strategique Multi-Annuel
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Annee</th>
                            <th class="text-end">Rev. Brut (M$)</th>
                            <th class="text-end">Redevances (M$)</th>
                            <th class="text-end">Cost Recovery (M$)</th>
                            <th class="text-end">Profit Oil (M$)</th>
                            <th class="text-end">Part Senegal (M$)</th>
                            <th class="text-end">Part Operateur (M$)</th>
                            <th class="text-end">Cashflow (M$)</th>
                            <th class="text-end">VAN Cumul. (M$)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashflows as $index => $cf)
                            <tr>
                                <td><span class="badge-modern badge-blue">{{ $cf->year }}</span></td>
                                <td class="text-end fw-semibold">{{ number_format($cf->gross_revenue, 1) }}</td>
                                <td class="text-end" style="color: var(--danger);">{{ number_format($cf->royalties, 1) }}</td>
                                <td class="text-end" style="color: var(--info);">{{ number_format($cf->cost_recovery, 1) }}</td>
                                <td class="text-end fw-semibold" style="color: var(--success);">{{ number_format($cf->profit_oil, 1) }}</td>
                                <td class="text-end fw-semibold" style="color: var(--warning);">{{ number_format($cf->state_share + $cf->petrosen_share, 1) }}</td>
                                <td class="text-end fw-semibold" style="color: var(--success);">{{ number_format($cf->operator_share - $cf->income_tax, 1) }}</td>
                                <td class="text-end fw-bold {{ $cf->project_cashflow >= 0 ? '' : 'text-danger' }}">{{ number_format($cf->project_cashflow, 1) }}</td>
                                <td class="text-end fw-bold {{ $cumulativeNPV[$index] >= 0 ? '' : 'text-danger' }}">{{ number_format($cumulativeNPV[$index], 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="border-top: 2px solid var(--border);">
                        <tr style="font-weight: 700; background: var(--surface-secondary);">
                            <td class="fw-bold">Total</td>
                            <td class="text-end">{{ number_format($totalRevenue, 1) }}</td>
                            <td class="text-end" style="color: var(--danger);">{{ number_format($cashflows->sum('royalties'), 1) }}</td>
                            <td class="text-end" style="color: var(--info);">{{ number_format($cashflows->sum('cost_recovery'), 1) }}</td>
                            <td class="text-end" style="color: var(--success);">{{ number_format($cashflows->sum('profit_oil'), 1) }}</td>
                            <td class="text-end" style="color: var(--warning);">{{ number_format($totalState, 1) }}</td>
                            <td class="text-end" style="color: var(--success);">{{ number_format($totalOperator, 1) }}</td>
                            <td class="text-end fw-bold">{{ number_format($cashflows->sum('project_cashflow'), 1) }}</td>
                            <td class="text-end fw-bold {{ $npvFinal >= 0 ? '' : 'text-danger' }}">{{ number_format($npvFinal, 1) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.font.weight = '500';

        const colors = {
            accent: '#3b82f6',
            success: '#10b981',
            warning: '#f59e0b',
            info: '#06b6d4',
            purple: '#8b5cf6',
            danger: '#ef4444',
            slate: '#64748b'
        };

        // 1. Cash Flow Bar Chart
        new Chart(document.getElementById('cashflowChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Revenu Brut',
                        data: @json($revenues),
                        backgroundColor: 'rgba(6, 182, 212, 0.7)',
                        borderRadius: 4,
                        borderSkipped: false,
                    },
                    {
                        label: 'Operateur',
                        data: @json($netProfits),
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderRadius: 4,
                        borderSkipped: false,
                    },
                    {
                        label: 'Senegal',
                        data: @json($stateShare),
                        backgroundColor: 'rgba(245, 158, 11, 0.7)',
                        borderRadius: 4,
                        borderSkipped: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, pointStyle: 'circle', padding: 20, font: { size: 12, weight: '600' } }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { weight: '700' },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} M$` }
                    }
                },
                scales: {
                    y: { grid: { color: '#f1f5f9', drawBorder: false }, ticks: { font: { size: 11 } }, beginAtZero: true },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });

        // 2. NPV Line Chart
        new Chart(document.getElementById('npvChart'), {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'VAN Cumulative',
                    data: @json($cumulativeNPV),
                    borderColor: colors.accent,
                    borderWidth: 3,
                    tension: 0.35,
                    fill: {
                        target: 'origin',
                        above: 'rgba(59, 130, 246, 0.08)',
                        below: 'rgba(239, 68, 68, 0.08)'
                    },
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: colors.accent,
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: { label: ctx => `VAN: ${ctx.parsed.y.toFixed(1)} M$` }
                    }
                },
                scales: {
                    y: {
                        grid: { color: '#f1f5f9', drawBorder: false },
                        ticks: { font: { size: 11 }, callback: v => v + ' M$' }
                    },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });

        // 3. Doughnut Chart
        new Chart(document.getElementById('distributionChart'), {
            type: 'doughnut',
            data: {
                labels: ['Senegal', 'Operateur', 'Taxes'],
                datasets: [{
                    data: [
                        {{ $totalState }},
                        {{ $totalOperator }},
                        {{ $totalTaxes }}
                    ],
                    backgroundColor: [colors.warning, colors.success, colors.accent],
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: { label: ctx => `${ctx.label}: ${ctx.parsed.toFixed(1)} M$` }
                    }
                }
            }
        });
    </script>
    <script src="https://unpkg.com/jspdf@2.5.2/dist/jspdf.umd.min.js"></script>
    <script>
        function exportChartPDF(canvasId, title) {
            try {
                var canvas = document.getElementById(canvasId);
                if (!canvas) { alert('Canvas introuvable'); return; }
                if (!window.jspdf) { alert('Librairie PDF en cours de chargement, reessayez'); return; }
                var imgData = canvas.toDataURL('image/png', 1.0);
                var pdf = new window.jspdf.jsPDF('landscape', 'mm', 'a4');

                pdf.setFillColor(10, 22, 40);
                pdf.rect(0, 0, 297, 25, 'F');
                pdf.setFont('helvetica', 'bold');
                pdf.setFontSize(8);
                pdf.setTextColor(100, 255, 218);
                pdf.text('COS-PETROGAZ', 15, 10);
                pdf.setFontSize(14);
                pdf.setTextColor(255, 255, 255);
                pdf.text(title.replace(/_/g, ' '), 15, 18);
                pdf.setFontSize(8);
                pdf.setTextColor(150, 150, 170);
                pdf.text('{{ $project->name }}', 200, 10);
                pdf.text('{{ now()->format("d/m/Y H:i") }}', 200, 15);

                var ratio = canvas.width / canvas.height;
                var imgW = 260;
                var imgH = imgW / ratio;
                if (imgH > 155) { imgH = 155; imgW = imgH * ratio; }
                var x = (297 - imgW) / 2;
                pdf.addImage(imgData, 'PNG', x, 32, imgW, imgH);

                pdf.setFontSize(7);
                pdf.setTextColor(160, 174, 192);
                pdf.text('COS-PETROGAZ - Rapport genere automatiquement', 148.5, 200, { align: 'center' });

                pdf.save(title + '.pdf');
            } catch(e) {
                alert('Erreur: ' + e.message);
                console.error(e);
            }
        }
    </script>
    @endpush
</x-app-layout>
