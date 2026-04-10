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
            <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">Mes Simulations</h1>
            <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">Gerez et analysez vos modeles economiques petroliers</p>
        </div>
     <?php $__env->endSlot(); ?>

     <?php $__env->slot('actions', null, []); ?> 
        <a href="<?php echo e(route('projects.create')); ?>" class="btn btn-accent">
            <i class="bi bi-plus-lg me-1"></i> Nouveau Modele
        </a>
     <?php $__env->endSlot(); ?>

    <?php if($projects->isEmpty()): ?>
        <div class="card-modern p-5 text-center" style="margin-top: 4rem;">
            <div style="width: 72px; height: 72px; background: var(--accent-light); border-radius: var(--radius-xl); display: inline-flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i class="bi bi-bar-chart-line-fill" style="font-size: 1.75rem; color: var(--accent);"></i>
            </div>
            <h3 class="fw-bold mb-2" style="font-size: 1.25rem;">Aucune simulation</h3>
            <p style="color: var(--text-secondary); max-width: 400px; margin: 0 auto 1.5rem; font-size: 0.9rem;">
                Modelisez vos revenus, calculez le TRI (IRR) et visualisez vos flux de tresorerie en quelques clics.
            </p>
            <a href="<?php echo e(route('projects.create')); ?>" class="btn btn-accent px-4 py-2">
                <i class="bi bi-plus-lg me-1"></i> Demarrer une modelisation
            </a>
        </div>
    <?php else: ?>
        <!-- Stats Summary -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="kpi-card kpi-blue">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Total Projets</div>
                            <div class="kpi-value" style="color: var(--accent);"><?php echo e($projects->count()); ?></div>
                        </div>
                        <div class="kpi-icon" style="background: var(--accent-light);">
                            <i class="bi bi-folder-fill" style="color: var(--accent);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kpi-card kpi-green">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Code 2019</div>
                            <div class="kpi-value" style="color: var(--success);"><?php echo e($projects->where('code_petrolier', '2019')->count()); ?></div>
                        </div>
                        <div class="kpi-icon" style="background: #d1fae5;">
                            <i class="bi bi-shield-check" style="color: var(--success);"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="kpi-card kpi-amber">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="kpi-label">Code 1998</div>
                            <div class="kpi-value" style="color: var(--warning);"><?php echo e($projects->where('code_petrolier', '1998')->count()); ?></div>
                        </div>
                        <div class="kpi-icon" style="background: #fef3c7;">
                            <i class="bi bi-clock-history" style="color: var(--warning);"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projects Grid -->
        <div class="row g-3">
            <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-xl-4">
                    <div class="card-modern p-4 h-100 d-flex flex-column" style="animation: fadeInUp 0.3s ease <?php echo e($loop->index * 0.05); ?>s both;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div style="width: 42px; height: 42px; background: <?php echo e($project->type == 'offshore' ? 'var(--accent-light)' : '#ede9fe'); ?>; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                                <i class="bi <?php echo e($project->type == 'offshore' ? 'bi-water' : 'bi-geo-alt-fill'); ?>" style="font-size: 1.1rem; color: <?php echo e($project->type == 'offshore' ? 'var(--accent)' : '#7c3aed'); ?>;"></i>
                            </div>
                            <span class="badge-modern <?php echo e($project->code_petrolier == '2019' ? 'badge-blue' : 'badge-amber'); ?>">
                                CODE <?php echo e($project->code_petrolier); ?>

                            </span>
                        </div>

                        <h5 class="fw-bold mb-1 text-truncate" style="font-size: 1.05rem;"><?php echo e($project->name); ?></h5>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin-bottom: 1rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.4rem;">
                            <?php echo e($project->description ?: 'Aucune description disponible pour ce modele.'); ?>

                        </p>

                        <div class="d-flex gap-4 mb-3 pb-3" style="border-bottom: 1px solid var(--border-light);">
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Horizon</div>
                                <div class="fw-bold" style="font-size: 0.9rem;"><?php echo e($project->duration); ?> ans</div>
                            </div>
                            <div>
                                <div style="font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted);">Type</div>
                                <div class="fw-bold" style="font-size: 0.9rem;"><?php echo e(ucfirst($project->type)); ?></div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <a href="<?php echo e(route('projects.show', $project)); ?>" class="btn btn-ghost flex-fill">
                                <i class="bi bi-sliders me-1"></i> Gerer
                            </a>
                            <a href="<?php echo e(route('dashboards.show', $project)); ?>" class="btn btn-dark-modern flex-fill">
                                <i class="bi bi-graph-up me-1"></i> Analytics
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
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
<?php /**PATH /Users/CheikhDiop/projetWeb/cos_pretrogaz/resources/views/projects/index.blade.php ENDPATH**/ ?>