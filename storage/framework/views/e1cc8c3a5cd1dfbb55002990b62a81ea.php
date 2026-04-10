<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="auth-form-header">
        <h2 class="auth-form-title">Bienvenue</h2>
        <p class="auth-form-desc">Connectez-vous a votre espace de simulation</p>
    </div>

    <?php if(session('status')): ?>
        <div class="auth-status">
            <i class="bi bi-check-circle-fill"></i>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    <div class="auth-card">
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Adresse Email</label>
                <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>"
                    class="form-input" placeholder="vous@exemple.com" required autofocus autocomplete="username">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="form-error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Password -->
            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.4rem;">
                    <label for="password" style="margin-bottom: 0;">Mot de Passe</label>
                    <?php if(Route::has('password.request')): ?>
                        <a href="<?php echo e(route('password.request')); ?>" class="auth-link" style="font-size: 0.75rem;">
                            Mot de passe oublie ?
                        </a>
                    <?php endif; ?>
                </div>
                <input id="password" type="password" name="password"
                    class="form-input" placeholder="••••••••" required autocomplete="current-password">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="form-error"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Remember Me -->
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember">
                <label for="remember_me">Se souvenir de moi</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn-auth">
                <i class="bi bi-box-arrow-in-right" style="margin-right: 6px;"></i>
                Se Connecter
            </button>
        </form>
    </div>

    <div class="auth-footer">
        Pas encore de compte ? <a href="<?php echo e(route('register')); ?>">Creer un compte</a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /Users/CheikhDiop/projetWeb/cos_pretrogaz/resources/views/auth/login.blade.php ENDPATH**/ ?>