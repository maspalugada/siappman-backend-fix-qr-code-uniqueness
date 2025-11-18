<?php $__env->startSection('title', 'Units - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Unit</h1>
            <p style="color: var(--gray-600);">Kelola unit untuk aset</p>
        </div>
        <a href="<?php echo e(route('dashboard.units.create')); ?>" class="btn btn-primary">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                <path d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
            </svg>
            Tambah Unit Baru
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success" style="margin-bottom: 1.5rem;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
            </svg>
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-error" style="margin-bottom: 1.5rem;">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
            </svg>
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin: 0;">Daftar Unit</h3>
        </div>
        <div class="card-body">
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Nama Unit</th>
                            <th style="width: 25%;">Kode Unit</th>
                            <th style="width: 20%;">Dibuat Pada</th>
                            <th style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 500; color: var(--gray-900);"><?php echo e($unit->name); ?></div>
                                </td>
                                <td>
                                    <span class="badge" style="background-color: var(--gray-100); color: var(--gray-700); padding: 0.25rem 0.5rem; border-radius: 0.25rem; font-size: 0.75rem; font-weight: 500;">
                                        <?php echo e($unit->code ?: 'Tidak ada kode'); ?>

                                    </span>
                                </td>
                                <td style="color: var(--gray-600); font-size: 0.875rem;">
                                    <?php echo e($unit->created_at->format('d M Y, H:i')); ?>

                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.25rem;">
                                        <a href="<?php echo e(route('dashboard.units.edit', $unit)); ?>" class="btn btn-sm btn-warning" title="Edit Unit">
                                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 0 .5.5h-11a.5.5 0 0 0-.5-.5v-11a.5.5 0 0 0 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                            </svg>
                                        </a>
                                        <form action="<?php echo e(route('dashboard.units.destroy', $unit)); ?>" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus unit ini?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus Unit">
                                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 3rem;">
                                    <div style="color: var(--gray-400);">
                                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16" style="margin-bottom: 1rem;">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M5 6.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm1.138-1.496a1.098 1.098 0 1 0 1.83.031A1.098 1.098 0 0 0 6.138 4.754zm3.724 0a1.098 1.098 0 1 0 1.83-.031 1.098 1.098 0 0 0-1.83.031z"/>
                                        </svg>
                                        <p style="font-size: 1.125rem; font-weight: 500; margin-bottom: 0.5rem;">Tidak ada unit ditemukan</p>
                                        <p style="color: var(--gray-500);">Belum ada unit yang dibuat. Klik tombol "Tambah Unit Baru" untuk memulai.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($units->hasPages()): ?>
                <div style="margin-top: 1.5rem; display: flex; justify-content: center;">
                    <?php echo e($units->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.badge {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 500;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    vertical-align: baseline;
    border-radius: 0.25rem;
}

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: flex-start;
}

.alert-success {
    background-color: #d1fae5;
    border: 1px solid #a7f3d0;
    color: #065f46;
}

.alert-error {
    background-color: #fee2e2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background-color: var(--gray-50);
}

.card-body {
    padding: 1.5rem;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    padding: 0.75rem 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--gray-700);
    border-bottom: 1px solid var(--gray-200);
    background-color: var(--gray-50);
}

.table td {
    padding: 1rem;
    border-bottom: 1px solid var(--gray-200);
}

.table tbody tr:hover {
    background-color: var(--gray-50);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    color: white;
    text-decoration: none;
}

.btn-warning {
    background-color: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background-color: #d97706;
    color: white;
}

.btn-danger {
    background-color: #ef4444;
    color: white;
}

.btn-danger:hover {
    background-color: #dc2626;
    color: white;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/units/index.blade.php ENDPATH**/ ?>