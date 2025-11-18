<?php $__env->startSection('title', 'Create Instrument Set - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 2rem;">Create New Instrument Set</h1>

    <div class="card">
        <div class="card-body">
            <form action="<?php echo e(route('dashboard.instrument-sets.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="name" class="form-label">Set Name</label>
                    <input type="text" id="name" name="name" class="form-input" value="<?php echo e(old('name')); ?>" required>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="form-input" rows="4"><?php echo e(old('description')); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="jumlah" class="form-label">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-input" value="<?php echo e(old('jumlah', 1)); ?>" min="1" required>
                    <?php $__errorArgs = ['jumlah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Select Assets</label>
                    <div style="max-height: 300px; overflow-y: auto; border: 1px solid var(--gray-300); border-radius: 0.5rem; padding: 1rem;">
                        <?php $__empty_1 = true; $__currentLoopData = $assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div style="display: flex; align-items: center; margin-bottom: 0.5rem;">
                                <input type="checkbox" name="assets[]" id="asset_<?php echo e($asset->id); ?>" value="<?php echo e($asset->id); ?>" style="margin-right: 0.5rem;">
                                <label for="asset_<?php echo e($asset->id); ?>"><?php echo e($asset->name); ?> (<?php echo e($asset->instrument_type); ?>) - <?php echo e($asset->unit); ?> / <?php echo e($asset->location); ?></label>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>No assets available to add. <a href="<?php echo e(route('dashboard.assets.create')); ?>">Create one first.</a></p>
                        <?php endif; ?>
                    </div>
                    <?php $__errorArgs = ['assets'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                    <a href="<?php echo e(route('dashboard.instrument-sets.index')); ?>" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Set</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/instrument-sets/create.blade.php ENDPATH**/ ?>