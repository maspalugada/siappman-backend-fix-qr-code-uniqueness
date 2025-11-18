<?php $__env->startSection('title', 'Add New Location - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
            <a href="<?php echo e(route('dashboard.locations.index')); ?>" class="btn btn-outline-secondary btn-sm">
                <span>←</span> Kembali
            </a>
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin: 0;">Tambah Lokasi Baru</h1>
            </div>
        </div>
        <p style="color: var(--gray-600); margin-left: 3.5rem;">Buat lokasi baru untuk mengelola aset</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin: 0;">Form Tambah Lokasi</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo e(route('dashboard.locations.store')); ?>">
                <?php echo csrf_field(); ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lokasi *</label>
                            <input type="text" id="name" name="name" class="form-input" value="<?php echo e(old('name')); ?>" required placeholder="Contoh: Ruang Operasi Utama">
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
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit" class="form-label">Unit *</label>
                            <input type="text" id="unit" name="unit" class="form-input" value="<?php echo e(old('unit')); ?>" required placeholder="Contoh: Instalasi Bedah">
                            <?php $__errorArgs = ['unit'];
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
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit_code" class="form-label">Kode Unit *</label>
                            <input type="text" id="unit_code" name="unit_code" class="form-input" value="<?php echo e(old('unit_code')); ?>" required placeholder="Contoh: IB" style="text-transform: uppercase;">
                            <?php $__errorArgs = ['unit_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small style="color: var(--gray-500); font-size: 0.8rem;">Kode unit akan otomatis dibuat jika belum ada</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="floor" class="form-label">Lantai *</label>
                            <select id="floor" name="floor" class="form-input" required>
                                <option value="">Pilih Lantai</option>
                                <option value="B1" <?php echo e(old('floor') == 'LG' ? 'selected' : ''); ?>>B1 - Lantai Basement</option>
                                <option value="1" <?php echo e(old('floor') == '1' ? 'selected' : ''); ?>>1 - Lantai 1</option>
                                <option value="2" <?php echo e(old('floor') == '2' ? 'selected' : ''); ?>>2 - Lantai 2</option>
                                <option value="3" <?php echo e(old('floor') == '3' ? 'selected' : ''); ?>>3 - Lantai 3</option>
                                <option value="4" <?php echo e(old('floor') == '4' ? 'selected' : ''); ?>>4 - Lantai 4</option>
                                <option value="5" <?php echo e(old('floor') == '5' ? 'selected' : ''); ?>>5 - Lantai 5</option>
                                <option value="6" <?php echo e(old('floor') == '6' ? 'selected' : ''); ?>>6 - Lantai 6</option>
                                <option value="7" <?php echo e(old('floor') == '7' ? 'selected' : ''); ?>>7 - Lantai 7</option>
                                <option value="8" <?php echo e(old('floor') == '8' ? 'selected' : ''); ?>>8 - Lantai 8</option>
                                <option value="9" <?php echo e(old('floor') == '9' ? 'selected' : ''); ?>>9 - Lantai 9</option>
                                <option value="10" <?php echo e(old('floor') == '10' ? 'selected' : ''); ?>>10 - Lantai 10</option>
                            </select>
                            <?php $__errorArgs = ['floor'];
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
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200); display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <span>💾</span> Simpan Lokasi
                    </button>
                    <a href="<?php echo e(route('dashboard.locations.index')); ?>" class="btn btn-outline-secondary">
                        <span>❌</span> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/locations/create.blade.php ENDPATH**/ ?>