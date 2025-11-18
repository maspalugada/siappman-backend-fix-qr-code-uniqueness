<?php $__env->startSection('title', 'Admin Dashboard - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Admin Dashboard</h1>
        <p style="color: var(--gray-600);">Manage your application's master data</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card">
            <div class="card-body">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-800);">Instrument Types</h2>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;"><?php echo e($instrumentTypeCount); ?></p>
                <a href="<?php echo e(route('dashboard.instrument-types.index')); ?>" class="btn btn-secondary">Manage</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-800);">Units</h2>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;"><?php echo e($unitCount); ?></p>
                <a href="<?php echo e(route('dashboard.units.index')); ?>" class="btn btn-secondary">Manage</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-800);">Locations</h2>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;"><?php echo e($locationCount); ?></p>
                <a href="<?php echo e(route('dashboard.locations.index')); ?>" class="btn btn-secondary">Manage</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-800);">User Management</h2>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color); margin: 1rem 0;"><?php echo e(\App\Models\User::count()); ?></p>
                <a href="<?php echo e(route('dashboard.users.index')); ?>" class="btn btn-secondary">Manage Users</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-800);">Permission Settings</h2>
                <p style="font-size: 1rem; color: var(--gray-600); margin: 1rem 0;">Configure user access permissions</p>
                <a href="<?php echo e(route('dashboard.users.index')); ?>" class="btn btn-secondary">Manage Permissions</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/admin/index.blade.php ENDPATH**/ ?>