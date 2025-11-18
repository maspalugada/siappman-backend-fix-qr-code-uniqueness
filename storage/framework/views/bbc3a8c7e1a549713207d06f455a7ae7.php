<?php $__env->startSection('title', 'Add New Instrument Type - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Add New Instrument Type</h1>
        <p style="color: var(--gray-600);">Create a new instrument type</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('dashboard.instrument-types.store')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="name" class="form-label">Type Name *</label>
                    <input type="text" id="name" name="name" class="form-input" value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Create Type</button>
                    <a href="<?php echo e(route('dashboard.instrument-types.index')); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/instrument-types/create.blade.php ENDPATH**/ ?>