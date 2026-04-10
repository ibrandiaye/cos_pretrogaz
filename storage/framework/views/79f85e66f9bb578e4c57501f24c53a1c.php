<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'COS-PETROGAZ')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                -webkit-font-smoothing: antialiased;
                min-height: 100vh;
                display: flex;
                background: #0f172a;
                color: #1e293b;
            }

            /* ── Left Panel (Branding) ── */
            .auth-brand {
                width: 45%;
                min-height: 100vh;
                background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                padding: 3rem;
                position: relative;
                overflow: hidden;
            }
            .auth-brand::before {
                content: '';
                position: absolute;
                width: 500px;
                height: 500px;
                background: radial-gradient(circle, rgba(59,130,246,0.12) 0%, transparent 70%);
                top: -100px;
                right: -100px;
                border-radius: 50%;
            }
            .auth-brand::after {
                content: '';
                position: absolute;
                width: 400px;
                height: 400px;
                background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
                bottom: -80px;
                left: -80px;
                border-radius: 50%;
            }
            .brand-content {
                position: relative;
                z-index: 1;
                text-align: center;
                max-width: 380px;
            }
            .brand-logo {
                width: 56px;
                height: 56px;
                background: linear-gradient(135deg, #3b82f6, #8b5cf6);
                border-radius: 14px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1.5rem;
            }
            .brand-logo i { font-size: 1.5rem; color: white; }
            .brand-title {
                font-size: 1.75rem;
                font-weight: 800;
                color: white;
                letter-spacing: -0.03em;
                margin-bottom: 0.5rem;
            }
            .brand-title span { color: #3b82f6; }
            .brand-subtitle {
                font-size: 0.9rem;
                color: rgba(255,255,255,0.5);
                line-height: 1.6;
                margin-bottom: 2.5rem;
            }

            /* Stats */
            .brand-stats {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 12px;
                width: 100%;
            }
            .brand-stat {
                background: rgba(255,255,255,0.05);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 12px;
                padding: 16px;
                text-align: center;
            }
            .brand-stat-value {
                font-size: 1.25rem;
                font-weight: 800;
                color: white;
            }
            .brand-stat-label {
                font-size: 0.65rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                color: rgba(255,255,255,0.35);
                margin-top: 2px;
            }
            .brand-stat.blue .brand-stat-value { color: #3b82f6; }
            .brand-stat.purple .brand-stat-value { color: #8b5cf6; }
            .brand-stat.green .brand-stat-value { color: #10b981; }
            .brand-stat.amber .brand-stat-value { color: #f59e0b; }

            /* ── Right Panel (Form) ── */
            .auth-form-panel {
                flex: 1;
                min-height: 100vh;
                background: #f8fafc;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }
            .auth-form-container {
                width: 100%;
                max-width: 420px;
            }
            .auth-form-header {
                margin-bottom: 2rem;
            }
            .auth-form-title {
                font-size: 1.5rem;
                font-weight: 800;
                color: #0f172a;
                letter-spacing: -0.02em;
                margin-bottom: 0.35rem;
            }
            .auth-form-desc {
                font-size: 0.875rem;
                color: #64748b;
            }

            /* Form card */
            .auth-card {
                background: white;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 2rem;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            }

            /* Form elements */
            .form-group { margin-bottom: 1.25rem; }
            .form-group label {
                display: block;
                font-size: 0.75rem;
                font-weight: 600;
                color: #64748b;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                margin-bottom: 0.4rem;
            }
            .form-input {
                width: 100%;
                padding: 0.7rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                font-family: 'Inter', sans-serif;
                color: #0f172a;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                outline: none;
                transition: all 0.15s ease;
            }
            .form-input:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
                background: white;
            }
            .form-input::placeholder { color: #94a3b8; }
            .form-error {
                font-size: 0.75rem;
                color: #ef4444;
                margin-top: 0.35rem;
                font-weight: 500;
            }

            /* Checkbox */
            .form-check {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-bottom: 1.25rem;
            }
            .form-check input[type="checkbox"] {
                width: 16px;
                height: 16px;
                border-radius: 4px;
                accent-color: #3b82f6;
                cursor: pointer;
            }
            .form-check label {
                font-size: 0.85rem;
                color: #64748b;
                font-weight: 500;
                margin: 0;
                text-transform: none;
                letter-spacing: 0;
                cursor: pointer;
            }

            /* Buttons */
            .btn-auth {
                width: 100%;
                padding: 0.75rem;
                font-size: 0.9rem;
                font-weight: 700;
                font-family: 'Inter', sans-serif;
                color: white;
                background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
                border: none;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.2s ease;
                box-shadow: 0 2px 8px rgba(59,130,246,0.3);
            }
            .btn-auth:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 16px rgba(59,130,246,0.4);
            }
            .btn-auth:active { transform: translateY(0); }

            /* Links */
            .auth-link {
                font-size: 0.825rem;
                color: #3b82f6;
                text-decoration: none;
                font-weight: 600;
                transition: color 0.15s;
            }
            .auth-link:hover { color: #2563eb; }

            .auth-footer {
                text-align: center;
                margin-top: 1.5rem;
                font-size: 0.85rem;
                color: #94a3b8;
            }
            .auth-footer a { color: #3b82f6; font-weight: 600; text-decoration: none; }
            .auth-footer a:hover { color: #2563eb; }

            /* Divider */
            .auth-divider {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin: 1.5rem 0;
                font-size: 0.75rem;
                color: #94a3b8;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }
            .auth-divider::before, .auth-divider::after {
                content: '';
                flex: 1;
                height: 1px;
                background: #e2e8f0;
            }

            /* Session status */
            .auth-status {
                background: #ecfdf5;
                color: #065f46;
                padding: 0.75rem 1rem;
                border-radius: 10px;
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 1.25rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            /* Responsive */
            @media (max-width: 991.98px) {
                .auth-brand { display: none; }
                .auth-form-panel { padding: 1.5rem; }
            }
        </style>
    </head>
    <body>
        <!-- Left Brand Panel -->
        <div class="auth-brand">
            <div class="brand-content">
                <div class="brand-logo">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <h1 class="brand-title">COS-<span>PETROGAZ</span></h1>
                <p class="brand-subtitle">
                    Plateforme de modelisation economique pour l'evaluation de projets petroliers et gaziers au Senegal.
                </p>
                <div class="brand-stats">
                    <div class="brand-stat blue">
                        <div class="brand-stat-value">2</div>
                        <div class="brand-stat-label">Codes Petroliers</div>
                    </div>
                    <div class="brand-stat purple">
                        <div class="brand-stat-value">5</div>
                        <div class="brand-stat-label">Scenarios</div>
                    </div>
                    <div class="brand-stat green">
                        <div class="brand-stat-value">NPV</div>
                        <div class="brand-stat-label">& IRR Calcules</div>
                    </div>
                    <div class="brand-stat amber">
                        <div class="brand-stat-value">R-Factor</div>
                        <div class="brand-stat-label">Code 2019</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="auth-form-panel">
            <div class="auth-form-container">
                <?php echo e($slot); ?>

            </div>
        </div>
    </body>
</html>
<?php /**PATH /Users/CheikhDiop/projetWeb/cos_pretrogaz/resources/views/layouts/guest.blade.php ENDPATH**/ ?>