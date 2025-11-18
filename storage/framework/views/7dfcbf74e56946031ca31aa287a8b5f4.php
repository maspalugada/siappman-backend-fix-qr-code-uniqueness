<?php $__env->startSection('title', 'Instrument Types - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Instrument Types</h1>
            <p style="color: var(--gray-600);">Manage your instrument types</p>
        </div>
        <a href="<?php echo e(route('dashboard.instrument-types.create')); ?>" class="btn btn-primary">Add New Type</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $instrumentTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($type->name); ?></td>
                                <td><?php echo e($type->created_at->format('d M Y, H:i')); ?></td>
                                <td>
                                    <div style="display: flex; gap: 0.5rem;">
                                        <a href="<?php echo e(route('dashboard.instrument-types.edit', $type)); ?>" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="<?php echo e(route('dashboard.instrument-types.destroy', $type)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 2rem;">
                                    <p style="color: var(--gray-600);">No instrument types found.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div style="margin-top: 1.5rem;">
                <?php echo e($instrumentTypes->links()); ?>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/instrument-types/index.blade.php ENDPATH**/ ?>