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
        <div class="d-flex align-items-center gap-3">
            <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-ghost" style="padding: 0.45rem 0.65rem;">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div>
                <h1 class="fw-bold mb-0" style="font-size: 1.35rem; letter-spacing: -0.02em;">Nouveau Projet</h1>
                <p class="mb-0 mt-1" style="font-size: 0.8rem; color: var(--text-muted);">Configurez votre modele economique petrolier</p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="row justify-content-center animate-in">
        <div class="col-lg-8 col-xl-7">
            <div class="card-modern p-0 overflow-hidden">
                <!-- Header -->
                <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border);">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width: 42px; height: 42px; background: var(--accent-light); border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-file-earmark-plus" style="font-size: 1.1rem; color: var(--accent);"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0" style="font-size: 1rem;">Informations du projet</h5>
                            <p class="mb-0" style="font-size: 0.8rem; color: var(--text-muted);">Remplissez les details de base de votre projet</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <form action="<?php echo e(route('projects.store')); ?>" method="POST" style="padding: 2rem;">
                    <?php echo csrf_field(); ?>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label-modern">Nom du Projet</label>
                            <input type="text" name="name" required value="<?php echo e(old('name')); ?>" placeholder="Ex: Projet Sangomar Phase 2"
                                class="form-control form-modern form-control-lg">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-1" style="font-size: 0.8rem; color: var(--danger);"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern">Code Petrolier</label>
                            <select name="code_petrolier" required class="form-select form-modern form-select-lg">
                                <option value="2019" <?php echo e(old('code_petrolier') == '2019' ? 'selected' : ''); ?>>Code 2019 (R-Factor)</option>
                                <option value="1998" <?php echo e(old('code_petrolier') == '1998' ? 'selected' : ''); ?>>Code 1998 (Tax/Tranches)</option>
                            </select>
                            <div class="mt-1" style="font-size: 0.75rem; color: var(--text-muted);">
                                <i class="bi bi-info-circle me-1"></i> Le code 2019 utilise le mecanisme R-Factor progressif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label-modern">Duree (annees)</label>
                            <input type="number" name="duration" value="<?php echo e(old('duration', 20)); ?>" min="1" max="50" required
                                class="form-control form-modern form-control-lg">
                            <?php $__errorArgs = ['duration'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="mt-1" style="font-size: 0.8rem; color: var(--danger);"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="col-12">
                            <label class="form-label-modern">Type de Gisement</label>
                            <div class="row g-3">
                                <div class="col-6">
                                    <label style="display: block; cursor: pointer;">
                                        <input type="radio" name="type" value="offshore" <?php echo e(old('type', 'offshore') == 'offshore' ? 'checked' : ''); ?> class="d-none" onchange="this.closest('.row').querySelectorAll('.type-card').forEach(c=>c.classList.remove('selected')); this.closest('.type-card').classList.add('selected');">
                                        <div class="type-card card-modern p-3 text-center selected" style="border-width: 2px; transition: all 0.15s ease;">
                                            <i class="bi bi-water d-block mb-2" style="font-size: 1.5rem; color: var(--accent);"></i>
                                            <div class="fw-bold" style="font-size: 0.9rem;">Offshore</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">Gisement en mer</div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <label style="display: block; cursor: pointer;">
                                        <input type="radio" name="type" value="onshore" <?php echo e(old('type') == 'onshore' ? 'checked' : ''); ?> class="d-none" onchange="this.closest('.row').querySelectorAll('.type-card').forEach(c=>c.classList.remove('selected')); this.closest('.type-card').classList.add('selected');">
                                        <div class="type-card card-modern p-3 text-center" style="border-width: 2px; transition: all 0.15s ease;">
                                            <i class="bi bi-geo-alt-fill d-block mb-2" style="font-size: 1.5rem; color: #7c3aed;"></i>
                                            <div class="fw-bold" style="font-size: 0.9rem;">Onshore</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">Gisement terrestre</div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label-modern">Description <span style="font-weight: 400; color: var(--text-muted);">(optionnel)</span></label>
                            <textarea name="description" rows="3" placeholder="Decrivez brievement le projet..."
                                class="form-control form-modern"><?php echo e(old('description')); ?></textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
                        <a href="<?php echo e(route('projects.index')); ?>" class="btn btn-ghost">Annuler</a>
                        <button type="submit" class="btn btn-accent px-4">
                            <i class="bi bi-check-lg me-1"></i> Creer le Projet
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="type"]').forEach(function(radio) {
                if (radio.checked) {
                    radio.closest('.type-card').classList.add('selected');
                }
            });
        });
    </script>
    <?php $__env->stopPush(); ?>

    <style>
        .type-card.selected { border-color: var(--accent) !important; background: var(--accent-light) !important; }
    </style>
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
<?php /**PATH /Users/CheikhDiop/projetWeb/cos_pretrogaz/resources/views/projects/create.blade.php ENDPATH**/ ?>