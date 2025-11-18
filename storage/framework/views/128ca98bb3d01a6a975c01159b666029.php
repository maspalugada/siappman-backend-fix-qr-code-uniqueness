<?php $__env->startSection('title', 'Dashboard - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Dashboard</h1>
        <p style="color: var(--gray-600);">Selamat Datang kembali, <?php echo e(Auth::user()->name); ?>!</p>
    </div>

    <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- QR Codes Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">📱</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">QR Codes</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">Manage QR codes</p>
                    </div>
                </div>
                <a href="<?php echo e(route('dashboard.qr-codes')); ?>" class="btn btn-primary" style="width: 100%;">Manage QR Codes</a>
            </div>
        </div>

        <!-- Assets Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">📦</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">Assets</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">Manage instruments & equipment</p>
                    </div>
                </div>
                <a href="<?php echo e(route('dashboard.assets.index')); ?>" class="btn btn-primary" style="width: 100%;">Manage Assets</a>
            </div>
        </div>

        <!-- Scan History Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">📊</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">Scan History</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">View scan activities</p>
                    </div>
                </div>
                <a href="<?php echo e(route('dashboard.scan-history')); ?>" class="btn btn-primary" style="width: 100%;">View History</a>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="card">
            <div class="card-body">
                <div style="display: flex; align-items: center; margin-bottom: 1rem;">
                    <div style="font-size: 2rem; margin-right: 1rem;">👤</div>
                    <div>
                        <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.25rem;">Profile</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem;">Manage your account</p>
                    </div>
                </div>
                <a href="<?php echo e(route('dashboard.profile')); ?>" class="btn btn-primary" style="width: 100%;">Edit Profile</a>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            .card-body h3 {
                font-size: 1.1rem;
            }

            .card-body p {
                font-size: 0.8rem;
            }

            .card-body div[style*="font-size: 2rem"] {
                font-size: 1.5rem !important;
            }
        }

        @media (max-width: 480px) {
            .dashboard-grid {
                gap: 0.75rem;
            }

            .card-body {
                padding: 0.75rem;
            }

            .card-body h3 {
                font-size: 1rem;
            }

            .card-body p {
                font-size: 0.75rem;
            }

            .card-body div[style*="font-size: 2rem"] {
                font-size: 1.25rem !important;
            }
        }
    </style>

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="<?php echo e(route('scanner')); ?>" class="btn btn-primary">
                    <span style="margin-right: 0.5rem;">📱</span>
                    Start Scanning
                </a>
                <a href="<?php echo e(route('dashboard.assets.create')); ?>" class="btn btn-secondary">
                    <span style="margin-right: 0.5rem;">+</span>
                    Add New Asset
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard.blade.php ENDPATH**/ ?>