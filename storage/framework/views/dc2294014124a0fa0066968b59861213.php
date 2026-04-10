<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div>
            <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">
                <?php echo e($project->name); ?> <span style="color: var(--accent);">&mdash; Analytics</span>
            </h1>
            <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">
                Simulation #<?php echo e($project->id); ?> &middot; <?php echo e(ucfirst($project->type)); ?> &middot; Code <?php echo e($project->code_petrolier); ?>

            </p>
        </div>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('projects.show', $project)); ?>" class="btn btn-ghost">
            <i class="bi bi-sliders me-1"></i> Parametres
        </a>
        <a href="<?php echo e(route('dashboards.state', $project)); ?>" class="btn btn-ghost">
            <i class="bi bi-bank2 me-1"></i> Vue Etat
        </a>
        <form action="<?php echo e(route('simulations.run', $project)); ?>" method="POST" class="d-inline">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-accent">
                <i class="bi bi-arrow-repeat me-1"></i> Actualiser
            </button>
        </form>
     <?php $__env->endSlot(); ?>

    <?php if($cashflows->isEmpty()): ?>
        <div class="card-modern p-5 text-center" style="margin-top: 3rem;">
            <div style="width: 72px; height: 72px; background: #fef3c7; border-radius: var(--radius-xl); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i class="bi bi-lightning-charge" style="font-size: 1.75rem; color: var(--warning);"></i>
            </div>
            <h3 class="fw-bold mb-2" style="font-size: 1.25rem;">Aucune simulation</h3>
            <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 1.5rem; font-size: 0.9rem;">
                Lancez une simulation pour visualiser les resultats economiques de votre projet.
            </p>
            <form action="<?php echo e(route('simulations.run', $project)); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-accent px-4 py-2">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Lancer la Simulation
                </button>
            </form>
        </div>
    <?php else: ?>
        <?php
            $totalRevenue = $cashflows->sum('gross_revenue');
            $totalState = $cashflows->sum('state_share') + $cashflows->sum('petrosen_share');
            $totalOperator = $cashflows->sum('operator_share') - $cashflows->sum('income_tax');
            $totalTaxes = $cashflows->sum('income_tax') + $cashflows->sum('royalties') + $cashflows->sum('cel') + $cashflows->sum('export_tax');
            $npvFinal = count($cumulativeNPV) > 0 ? end($cumulativeNPV) : 0;
            $totalCapex = $cashflows->sum('capex_total');
            $totalOpex = $cashflows->sum('opex_total');
        ?>

        <!-- KPI Row -->
        <div class="row g-3 mb-4 animate-in">
            <div class="col-6 col-xl-2">
                <div class="kpi-card kpi-blue h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">VAN (NPV)</div>
                            <div class="kpi-value" style="color: var(--accent);"><?php echo e(number_format($npvFinal, 1)); ?><span class="kpi-unit">M$</span></div>
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
                            <div class="kpi-value" style="color: var(--success);"><?php echo e($irr !== null ? number_format($irr, 1) : '--'); ?><span class="kpi-unit">%</span></div>
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
                            <div class="kpi-value" style="color: var(--info);"><?php echo e(number_format($totalRevenue, 1)); ?><span class="kpi-unit">M$</span></div>
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
                            <div class="kpi-value" style="color: var(--warning);"><?php echo e(number_format($totalState, 1)); ?><span class="kpi-unit">M$</span></div>
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
                            <div class="kpi-value" style="color: #7c3aed;"><?php echo e(number_format($totalCapex, 1)); ?><span class="kpi-unit">M$</span></div>
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
                            <div class="kpi-value" style="color: var(--danger);"><?php echo e(number_format($totalTaxes, 1)); ?><span class="kpi-unit">M$</span></div>
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
                        <span class="badge-modern badge-blue">M$</span>
                    </div>
                    <div style="height: 320px;">
                        <canvas id="cashflowChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card-modern p-4 h-100">
                    <h6 class="fw-bold mb-4" style="font-size: 0.9rem;">Repartition des Revenus</h6>
                    <div class="d-flex align-items-center justify-content-center" style="height: 200px;">
                        <canvas id="distributionChart"></canvas>
                    </div>
                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #f59e0b; display: inline-block;"></span>
                                <span class="fw-semibold">Senegal</span>
                            </div>
                            <span class="fw-bold"><?php echo e(number_format($totalState, 1)); ?> M$</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                                <span class="fw-semibold">Operateur</span>
                            </div>
                            <span class="fw-bold"><?php echo e(number_format($totalOperator, 1)); ?> M$</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center" style="font-size: 0.8rem;">
                            <div class="d-flex align-items-center gap-2">
                                <span style="width: 10px; height: 10px; border-radius: 50%; background: #3b82f6; display: inline-block;"></span>
                                <span class="fw-semibold">Taxes</span>
                            </div>
                            <span class="fw-bold"><?php echo e(number_format($totalTaxes, 1)); ?> M$</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- NPV Chart -->
        <div class="card-modern p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Evolution de la VAN Cumulative</h6>
                <span class="badge-modern <?php echo e($npvFinal >= 0 ? 'badge-green' : 'badge-amber'); ?>">
                    <?php echo e($npvFinal >= 0 ? 'Projet Rentable' : 'VAN Negative'); ?>

                </span>
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
                        <?php $__currentLoopData = $cashflows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $cf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><span class="badge-modern badge-blue"><?php echo e($cf->year); ?></span></td>
                                <td class="text-end fw-semibold"><?php echo e(number_format($cf->gross_revenue, 1)); ?></td>
                                <td class="text-end" style="color: var(--danger);"><?php echo e(number_format($cf->royalties, 1)); ?></td>
                                <td class="text-end" style="color: var(--info);"><?php echo e(number_format($cf->cost_recovery, 1)); ?></td>
                                <td class="text-end fw-semibold" style="color: var(--success);"><?php echo e(number_format($cf->profit_oil, 1)); ?></td>
                                <td class="text-end fw-semibold" style="color: var(--warning);"><?php echo e(number_format($cf->state_share + $cf->petrosen_share, 1)); ?></td>
                                <td class="text-end fw-semibold" style="color: var(--success);"><?php echo e(number_format($cf->operator_share - $cf->income_tax, 1)); ?></td>
                                <td class="text-end fw-bold <?php echo e($cf->project_cashflow >= 0 ? '' : 'text-danger'); ?>"><?php echo e(number_format($cf->project_cashflow, 1)); ?></td>
                                <td class="text-end fw-bold <?php echo e($cumulativeNPV[$index] >= 0 ? '' : 'text-danger'); ?>"><?php echo e(number_format($cumulativeNPV[$index], 1)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                    <tfoot style="border-top: 2px solid var(--border);">
                        <tr style="font-weight: 700; background: var(--surface-secondary);">
                            <td class="fw-bold">Total</td>
                            <td class="text-end"><?php echo e(number_format($totalRevenue, 1)); ?></td>
                            <td class="text-end" style="color: var(--danger);"><?php echo e(number_format($cashflows->sum('royalties'), 1)); ?></td>
                            <td class="text-end" style="color: var(--info);"><?php echo e(number_format($cashflows->sum('cost_recovery'), 1)); ?></td>
                            <td class="text-end" style="color: var(--success);"><?php echo e(number_format($cashflows->sum('profit_oil'), 1)); ?></td>
                            <td class="text-end" style="color: var(--warning);"><?php echo e(number_format($totalState, 1)); ?></td>
                            <td class="text-end" style="color: var(--success);"><?php echo e(number_format($totalOperator, 1)); ?></td>
                            <td class="text-end fw-bold"><?php echo e(number_format($cashflows->sum('project_cashflow'), 1)); ?></td>
                            <td class="text-end fw-bold <?php echo e($npvFinal >= 0 ? '' : 'text-danger'); ?>"><?php echo e(number_format($npvFinal, 1)); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    <?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = <?php echo json_encode($labels, 15, 512) ?>;
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
                        data: <?php echo json_encode($revenues, 15, 512) ?>,
                        backgroundColor: 'rgba(6, 182, 212, 0.7)',
                        borderRadius: 4,
                        borderSkipped: false,
                    },
                    {
                        label: 'Operateur',
                        data: <?php echo json_encode($netProfits, 15, 512) ?>,
                        backgroundColor: 'rgba(16, 185, 129, 0.7)',
                        borderRadius: 4,
                        borderSkipped: false,
                    },
                    {
                        label: 'Senegal',
                        data: <?php echo json_encode($stateShare, 15, 512) ?>,
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
                    data: <?php echo json_encode($cumulativeNPV, 15, 512) ?>,
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
                        <?php echo e($totalState); ?>,
                        <?php echo e($totalOperator); ?>,
                        <?php echo e($totalTaxes); ?>

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
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/CheikhDiop/projetWeb/cos_pretrogaz/resources/views/dashboards/show.blade.php ENDPATH**/ ?>