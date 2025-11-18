<?php $__env->startSection('title', 'Profile - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Profile</h1>
        <p style="color: var(--gray-600);">Manage your account information</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Account Information</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('dashboard.profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" type="text" name="name" value="<?php echo e(auth()->user()->name); ?>" required class="form-input">
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
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" type="email" name="email" value="<?php echo e(auth()->user()->email); ?>" required class="form-input">
                        <?php $__errorArgs = ['email'];
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
                        <label for="role" class="form-label">Role</label>
                        <input type="text" value="<?php echo e(ucfirst(auth()->user()->role)); ?>" readonly class="form-input" style="background-color: var(--gray-100);">
                    </div>

                    <div class="form-group">
                        <label class="form-label">Member Since</label>
                        <input type="text" value="<?php echo e(auth()->user()->created_at->format('M d, Y')); ?>" readonly class="form-input" style="background-color: var(--gray-100);">
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Change Password</h2>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('dashboard.profile.password')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" type="password" name="current_password" required class="form-input">
                        <?php $__errorArgs = ['current_password'];
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
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" type="password" name="password" required class="form-input">
                        <?php $__errorArgs = ['password'];
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
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-input">
                        <?php $__errorArgs = ['password_confirmation'];
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
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/profile.blade.php ENDPATH**/ ?>