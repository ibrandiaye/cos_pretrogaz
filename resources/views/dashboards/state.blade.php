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
        <div class="dropdown d-inline">
            <button class="btn btn-ghost dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-download me-1"></i> Exporter
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0">
                <li><a class="dropdown-item fw-semibold" href="{{ route('exports.excel', $project) }}"><i class="bi bi-file-earmark-excel me-2 text-success"></i>Excel (.xlsx)</a></li>
                <li><a class="dropdown-item fw-semibold" href="{{ route('exports.pdf', $project) }}"><i class="bi bi-file-earmark-pdf me-2 text-danger"></i>PDF</a></li>
            </ul>
        </div>
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
            $totalWHT = $cashflows->sum('wht_dividendes');
            $totalBLT = $cashflows->sum('business_license_tax');
            $totalStateShare = $cashflows->sum('state_share');
            $totalPetrosenShare = $cashflows->sum('petrosen_share');
            $grandTotal = $totalRoyalties + $totalIS + $totalCEL + $totalExportTax + $totalWHT + $totalBLT + $totalStateShare + $totalPetrosenShare;
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
                    <div class="kpi-value" style="color: var(--danger);">{{ number_format($totalIS + $totalCEL + $totalExportTax + $totalWHT + $totalBLT, 1) }}<span class="kpi-unit">M$</span></div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row g-3 mb-4">
            <div class="col-xl-5">
                <div class="card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Decomposition des Revenus Etatiques</h6>
                        <button onclick="exportChartPDF('stateBreakdownChart', 'Decomposition_Revenus_Etatiques')" style="background: #fef2f2; color: #dc2626; border: none; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;" title="Exporter en PDF">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>
                    </div>
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
                                ['label' => 'WHT Dividendes', 'value' => $totalWHT, 'color' => '#f97316'],
                                ['label' => 'Business License Tax', 'value' => $totalBLT, 'color' => '#64748b'],
                            ];
                        @endphp
                        @php
                            $exportSlugs = ['redevances', 'profit-oil', 'petrosen', 'is', 'cel', 'taxe-export', 'wht', 'blt'];
                        @endphp
                        @foreach($items as $idx => $item)
                            <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <span style="width: 10px; height: 10px; border-radius: 50%; background: {{ $item['color'] }}; display: inline-block;"></span>
                                    <span class="fw-semibold">{{ $item['label'] }}</span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="fw-bold">{{ number_format($item['value'], 1) }} M$</span>
                                    <a href="{{ route('exports.state-component', [$project, $exportSlugs[$idx]]) }}"
                                       title="Exporter {{ $item['label'] }}"
                                       style="background: #dcfce7; color: #166534; width: 24px; height: 24px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; font-size: 0.7rem; transition: all 0.15s;">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-xl-7">
                <div class="card-modern p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Evolution Annuelle des Revenus Etatiques</h6>
                        <button onclick="exportChartPDF('stateTimelineChart', 'Evolution_Revenus_Etatiques')" style="background: #fef2f2; color: #dc2626; border: none; width: 28px; height: 28px; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 0.75rem;" title="Exporter en PDF">
                            <i class="bi bi-filetype-pdf"></i>
                        </button>
                    </div>
                    <div style="height: 350px;">
                        <canvas id="stateTimelineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="card-modern overflow-hidden">
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);" class="d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">
                    <i class="bi bi-table me-2" style="color: var(--warning);"></i> Detail Annuel des Revenus Etatiques
                </h6>
                <a href="{{ route('exports.state-component', [$project, 'total']) }}" style="background: #dcfce7; color: #166534; padding: 0.4rem 0.85rem; border-radius: 8px; font-size: 0.78rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 5px;">
                    <i class="bi bi-file-earmark-arrow-down"></i> Exporter Total Etat
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    @php
                        $cols = [
                            ['label' => 'Redevances', 'slug' => 'redevances'],
                            ['label' => 'Part Etat (Profit Oil)', 'slug' => 'profit-oil'],
                            ['label' => 'Part PETROSEN', 'slug' => 'petrosen'],
                            ['label' => 'IS', 'slug' => 'is'],
                            ['label' => 'CEL', 'slug' => 'cel'],
                            ['label' => 'Taxe Export', 'slug' => 'taxe-export'],
                            ['label' => 'WHT', 'slug' => 'wht'],
                            ['label' => 'BLT', 'slug' => 'blt'],
                        ];
                    @endphp
                    <thead>
                        <tr>
                            <th>Annee</th>
                            @foreach($cols as $col)
                                <th class="text-end">
                                    {{ $col['label'] }}
                                    <a href="{{ route('exports.state-component', [$project, $col['slug']]) }}"
                                       style="color: #10b981; background: rgba(16,185,129,0.15); width: 18px; height: 18px; border-radius: 4px; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; margin-left: 4px; vertical-align: middle;"
                                       title="Exporter {{ $col['label'] }}">
                                        <i class="bi bi-download" style="font-size: 0.6rem;"></i>
                                    </a>
                                </th>
                            @endforeach
                            <th class="text-end">Total Etat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cashflows as $cf)
                            @php $yearTotal = $cf->royalties + $cf->state_share + $cf->petrosen_share + $cf->income_tax + $cf->cel + $cf->export_tax + $cf->wht_dividendes + $cf->business_license_tax; @endphp
                            <tr>
                                <td><span class="badge-modern badge-blue">{{ $cf->year }}</span></td>
                                <td class="text-end" style="color: var(--warning);">{{ number_format($cf->royalties, 1) }}</td>
                                <td class="text-end" style="color: var(--accent);">{{ number_format($cf->state_share, 1) }}</td>
                                <td class="text-end" style="color: var(--success);">{{ number_format($cf->petrosen_share, 1) }}</td>
                                <td class="text-end" style="color: #7c3aed;">{{ number_format($cf->income_tax, 1) }}</td>
                                <td class="text-end" style="color: var(--info);">{{ number_format($cf->cel, 1) }}</td>
                                <td class="text-end" style="color: var(--danger);">{{ number_format($cf->export_tax, 1) }}</td>
                                <td class="text-end" style="color: #f97316;">{{ number_format($cf->wht_dividendes, 1) }}</td>
                                <td class="text-end" style="color: #64748b;">{{ number_format($cf->business_license_tax, 1) }}</td>
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
                            <td class="text-end" style="color: #f97316;">{{ number_format($totalWHT, 1) }}</td>
                            <td class="text-end" style="color: #64748b;">{{ number_format($totalBLT, 1) }}</td>
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
                labels: ['Redevances', 'Profit Oil Etat', 'PETROSEN', 'IS', 'CEL', 'Taxe Export', 'WHT', 'BLT'],
                datasets: [{
                    data: [{{ $totalRoyalties }}, {{ $totalStateShare }}, {{ $totalPetrosenShare }}, {{ $totalIS }}, {{ $totalCEL }}, {{ $totalExportTax }}, {{ $totalWHT }}, {{ $totalBLT }}],
                    backgroundColor: ['#f59e0b', '#3b82f6', '#10b981', '#8b5cf6', '#06b6d4', '#ef4444', '#f97316', '#64748b'],
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
