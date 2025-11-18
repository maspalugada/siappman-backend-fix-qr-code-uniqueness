<?php $__env->startSection('title', 'Locations - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Locations</h1>
            <p style="color: var(--gray-600);">Manage your locations</p>
        </div>
        <a href="<?php echo e(route('dashboard.locations.create')); ?>" class="btn btn-primary">Add New Location</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin: 0;">Daftar Lokasi</h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 25%;">Nama Lokasi</th>
                            <th style="width: 20%;">Unit</th>
                            <th style="width: 15%;">Kode Unit</th>
                            <th style="width: 15%;">Lantai</th>
                            <th style="width: 15%;">Dibuat</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 500; color: var(--gray-900);"><?php echo e($location->name); ?></div>
                                </td>
                                <td>
                                    <span class="badge badge-primary"><?php echo e($location->unit ?? '-'); ?></span>
                                </td>
                                <td>
                                    <code style="background: var(--gray-100); padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.875rem;"><?php echo e($location->unit_code ?? '-'); ?></code>
                                </td>
                                <td>
                                    <span class="badge badge-secondary"><?php echo e($location->floor ?? '-'); ?></span>
                                </td>
                                <td style="font-size: 0.875rem; color: var(--gray-600);">
                                    <?php echo e($location->created_at->format('d/m/Y')); ?>

                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.25rem;">
                                        <a href="<?php echo e(route('dashboard.locations.edit', $location)); ?>" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <span>✏️</span>
                                        </a>
                                        <form action="<?php echo e(route('dashboard.locations.destroy', $location)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <span>🗑️</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 3rem;">
                                    <div style="color: var(--gray-400);">
                                        <div style="font-size: 3rem; margin-bottom: 1rem;">📍</div>
                                        <p style="font-size: 1.1rem; margin-bottom: 0.5rem;">Belum ada lokasi</p>
                                        <p style="font-size: 0.9rem;">Tambahkan lokasi pertama Anda untuk memulai</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($locations->hasPages()): ?>
                <div style="margin-top: 2rem; display: flex; justify-content: center;">
                    <?php echo e($locations->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/locations/index.blade.php ENDPATH**/ ?>