<?php $__env->startSection('title', 'Welcome to SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="text-align: center; margin-bottom: 3rem;">
        <h1 style="font-size: 3rem; font-weight: 700; color: var(--gray-900); margin-bottom: 1rem;">Selamat Datang di SiAPPMan</h1>
        <p style="font-size: 1.25rem; color: var(--gray-600); max-width: 600px; margin: 0 auto;">Pemindai Kode QR dan Sistem Manajemen untuk pelacakan aset dan pemantauan aktivitas yang efisien</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--white); font-size: 2rem; font-weight: 700;">
                    📱
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Pemindaian Kode QR</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Pindai kode QR secara instan dengan perangkat seluler atau webcam Anda untuk pelacakan aktivitas waktu nyata</p>
                <a href="<?php echo e(route('scanner')); ?>" class="btn btn-primary">Mulai Memindai</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, var(--success), #34D399); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--white); font-size: 2rem; font-weight: 700;">
                    📊
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Pemantauan Aktivitas</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Lacak dan pantau semua aktivitas pemindaian dengan log dan analitik terperinci</p>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Lihat Dasbor</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body" style="text-align: center;">
                <div style="width: 4rem; height: 4rem; background: linear-gradient(135deg, var(--warning), #FBBF24); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: var(--white); font-size: 2rem; font-weight: 700;">
                    ⚙️
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Manajemen Aset</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Kelola kode QR untuk aset, lokasi, dan peralatan secara efisien</p>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">Kelola Aset</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h2 style="font-size: 2rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Get Started</h2>
            <p style="color: var(--gray-600); margin-bottom: 2rem; max-width: 500px; margin-left: auto; margin-right: auto;">Bergabunglah dengan SiAPPMan hari ini untuk menyederhanakan proses pelacakan aset dan pemantauan aktivitas Anda</p>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Buat Akun</a>
                <a href="<?php echo e(route('login')); ?>" class="btn btn-secondary">Masuk</a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/welcome.blade.php ENDPATH**/ ?>