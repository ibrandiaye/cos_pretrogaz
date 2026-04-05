<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">
                {{ $project->name }} <span style="color: var(--warning);">&mdash; Vue Etatique</span>
            </h1>
            <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">
                Repartition detaillee des revenus de l'Etat du Senegal
            </p>
        </div>
    </x-slot>

    <x-slot name="actions">
        <a href="{{ route('dashboards.show', $project) }}" class="btn btn-ghost">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </x-slot>

    @if($cashflows->isEmpty())
        <div class="card-modern p-5 text-center" style="margin-top: 3rem;">
            <div style="width: 72px; height: 72px; background: #fef3c7; border-radius: var(--radius-xl); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i class="bi bi-bank" style="font-size: 1.75rem; color: var(--warning);"></i>
            </div>
            <h3 class="fw-bold mb-2" style="font-size: 1.25rem;">Aucune donnee</h3>
            <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 1.5rem; font-size: 0.9rem;">
                Lancez une simulation pour visualiser la repartition etatique.
            </p>
        </div>
    @else
        @php
            $totalRoyalties = $cashflows->sum('royalties');
            $totalIS = $cashflows->sum('income_tax');
            $totalCEL = $cashflows->sum('cel');
            $totalExportTax = $cashflows->sum('export_tax');
            $totalStateShare = $cashflows->sum('state_share');
            $totalPetrosenShare = $cashflows->sum('petrosen_share');
            $grandTotal = $totalRoyalties + $totalIS + $totalCEL + $totalExportTax + $totalStateShare + $totalPetrosenShare;
            $totalRevenue = $cashflows->sum('gross_revenue');
            $governmentTake = $totalRevenue > 0 ? ($grandTotal / $totalRevenue) * 100 : 0;
        @endphp

        <!-- KPIs -->
        <div class="row g-3 mb-4 animate-in">
            <div class="col-md-3">
                <div class="kpi-card kpi-amber h-100">
                    <div class="kpi-label">Total Revenus Etat</div>
                    <div class="kpi-value" style="color: var(--warning);">{{ number_format($grandTotal, 1) }}<span class="kpi-unit">M$</span></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card kpi-blue h-100">
                    <div class="kpi-label">Government Take</div>
                    <div class="kpi-value" style="color: var(--accent);">{{ number_format($governmentTake, 1) }}<span class="kpi-unit">%</span></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card kpi-green h-100">
                    <div class="kpi-label">Part PETROSEN</div>
                    <div class="kpi-value" style="color: var(--success);">{{ number_format($totalPetrosenShare, 1) }}<span class="kpi-unit">M$</span></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="kpi-card kpi-red h-100">
                    <div class="kpi-label">Total Fiscalite</div>
                    <div class="kpi-value" style="color: var(--danger);">{{ number_format($totalIS + $totalCEL + $totalExportTax, 1) }}<span class="kpi-unit">M$</span></div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-4">
            <div class="col-xl-5">
                <div class="card-modern p-4 h-100">
                    <h6 class="fw-bold mb-4" style="font-size: 0.9rem;">Decomposition des Revenus Etatiques</h6>
                    <div class="d-flex justify-content-center" style="height: 240px;">
                        <canvas id="stateBreakdownChart"></canvas>
                    </div>
                    <div class="mt-4">
                        @php
                            $items = [
                                ['label' => 'Redevances', 'value' => $totalRoyalties, 'color' => '#f59e0b'],
                                ['label' => 'Profit Oil Etat', 'value' => $totalStateShare, 'color' => '#3b82f6'],
                                ['label' => 'Part PETROSEN', 'value' => $totalPetrosenShare, 'color' => '#10b981'],
                                ['label' => 'Impot Societe (IS)', 'value' => $totalIS, 'color' => '#8b5cf6'],
                                ['label' => 'CEL', 'value' => $totalCEL, 'color' => '#06b6d4'],
                                ['label' => 'Taxe Export', 'value' => $totalExportTax, 'color' => '#ef4444'],
                            ];
                        @endphp
                        @foreach($items as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width: 10px; height: 10px; border-radius: 50%; background: {{ $item['color'] }}; display: inline-block;"></span>
                                    <span class="fw-semibold">{{ $item['label'] }}</span>
                                </div>
                                <span class="fw-bold">{{ number_format($item['value'], 1) }} M$</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card-modern p-4 h-100">
                    <h6 class="fw-bold mb-4" style="font-size: 0.9rem;">Evolution Annuelle des Revenus Etatiques</h6>
                    <div style="height: 350px;">
                        <canvas id="stateTimelineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="card-modern overflow-hidden">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">
                    <i class="bi bi-table me-2" style="color: var(--warning);"></i> Detail Annuel des Revenus Etatiques
                </h6>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Annee</th>
                            <th class="text-end">Redevances</th>
                            <th class="text-end">Part Etat (Profit Oil)</th>
                            <th class="text-end">Part PETROSEN</th>
                            <th class="text-end">IS</th>
                            <th class="text-end">CEL</th>
                            <th class="text-end">Taxe Export</th>
                            <th class="text-end">Total Etat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashflows as $cf)
                            @php $yearTotal = $cf->royalties + $cf->state_share + $cf->petrosen_share + $cf->income_tax + $cf->cel + $cf->export_tax; @endphp
                            <tr>
                                <td><span class="badge-modern badge-blue">{{ $cf->year }}</span></td>
                                <td class="text-end" style="color: var(--warning);">{{ number_format($cf->royalties, 1) }}</td>
                                <td class="text-end" style="color: var(--accent);">{{ number_format($cf->state_share, 1) }}</td>
                                <td class="text-end" style="color: var(--success);">{{ number_format($cf->petrosen_share, 1) }}</td>
                                <td class="text-end" style="color: #7c3aed;">{{ number_format($cf->income_tax, 1) }}</td>
                                <td class="text-end" style="color: var(--info);">{{ number_format($cf->cel, 1) }}</td>
                                <td class="text-end" style="color: var(--danger);">{{ number_format($cf->export_tax, 1) }}</td>
                                <td class="text-end fw-bold">{{ number_format($yearTotal, 1) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot style="border-top: 2px solid var(--border);">
                        <tr style="font-weight: 700; background: var(--surface-secondary);">
                            <td class="fw-bold">Total</td>
                            <td class="text-end" style="color: var(--warning);">{{ number_format($totalRoyalties, 1) }}</td>
                            <td class="text-end" style="color: var(--accent);">{{ number_format($totalStateShare, 1) }}</td>
                            <td class="text-end" style="color: var(--success);">{{ number_format($totalPetrosenShare, 1) }}</td>
                            <td class="text-end" style="color: #7c3aed;">{{ number_format($totalIS, 1) }}</td>
                            <td class="text-end" style="color: var(--info);">{{ number_format($totalCEL, 1) }}</td>
                            <td class="text-end" style="color: var(--danger);">{{ number_format($totalExportTax, 1) }}</td>
                            <td class="text-end fw-bold">{{ number_format($grandTotal, 1) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.font.weight = '500';

        // Doughnut - State Breakdown
        new Chart(document.getElementById('stateBreakdownChart'), {
            type: 'doughnut',
            data: {
                labels: ['Redevances', 'Profit Oil Etat', 'PETROSEN', 'IS', 'CEL', 'Taxe Export'],
                datasets: [{
                    data: [{{ $totalRoyalties }}, {{ $totalStateShare }}, {{ $totalPetrosenShare }}, {{ $totalIS }}, {{ $totalCEL }}, {{ $totalExportTax }}],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#06b6d4', '#ef4444'],
                    borderWidth: 0,
                    spacing: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
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

        // Stacked Bar - Timeline
        const labels = @json($cashflows->pluck('year'));
        new Chart(document.getElementById('stateTimelineChart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    { label: 'Redevances', data: @json($cashflows->pluck('royalties')), backgroundColor: 'rgba(245,158,11,0.8)', borderRadius: 2 },
                    { label: 'Part Etat', data: @json($cashflows->pluck('state_share')), backgroundColor: 'rgba(59,130,246,0.8)', borderRadius: 2 },
                    { label: 'PETROSEN', data: @json($cashflows->pluck('petrosen_share')), backgroundColor: 'rgba(16,185,129,0.8)', borderRadius: 2 },
                    { label: 'IS', data: @json($cashflows->pluck('income_tax')), backgroundColor: 'rgba(139,92,246,0.8)', borderRadius: 2 },
                    { label: 'CEL', data: @json($cashflows->pluck('cel')), backgroundColor: 'rgba(6,182,212,0.8)', borderRadius: 2 },
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { usePointStyle: true, pointStyle: 'circle', padding: 15, font: { size: 11, weight: '600' } }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        cornerRadius: 8,
                        mode: 'index',
                        callbacks: { label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y.toFixed(1)} M$` }
                    }
                },
                scales: {
                    x: { stacked: true, grid: { display: false } },
                    y: { stacked: true, grid: { color: '#f1f5f9', drawBorder: false }, ticks: { callback: v => v + ' M$' } }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>
