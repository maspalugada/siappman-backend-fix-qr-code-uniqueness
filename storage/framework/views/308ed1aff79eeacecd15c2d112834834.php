<?php $__env->startSection('title', 'Register - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container" style="max-width: 400px; margin: 4rem auto;">
    <div class="card">
        <div class="card-header" style="text-align: center; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); color: var(--white);">
            <h1 style="margin: 0; font-size: 1.5rem;">Buat Akun</h1>
            <p style="margin: 0.5rem 0 0 0; opacity: 0.9;">Bergabung dengan SiappMan</p>
        </div>

        <div class="card-body">
            <form method="POST" action="<?php echo e(route('register')); ?>">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text" name="name" value="<?php echo e(old('name')); ?>" required class="form-input">
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
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required class="form-input">
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
                    <select id="role" name="role" required class="form-input">
                        <option value="">Select Role</option>
                        <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
                        <option value="staff" <?php echo e(old('role') == 'staff' ? 'selected' : ''); ?>>Staff</option>
                    </select>
                    <?php $__errorArgs = ['role'];
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
                    <label for="password" class="form-label">Password</label>
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
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
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

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
                    Create Account
                </button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                <p style="margin: 0; color: var(--gray-600); font-size: 0.875rem;">
                    Sudah punya akun?
                    <a href="<?php echo e(route('login')); ?>" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Masuk</a>
                </p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/auth/register.blade.php ENDPATH**/ ?>