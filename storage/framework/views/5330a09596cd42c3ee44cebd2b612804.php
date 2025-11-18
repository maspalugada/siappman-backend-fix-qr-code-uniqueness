<?php $__env->startSection('title', $asset->name . ' - Asset Details - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;"><?php echo e($asset->name); ?></h1>
                <p style="color: var(--gray-600); font-family: monospace;"><?php echo e($asset->qr_code); ?></p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="<?php echo e(route('dashboard.assets.edit', $asset)); ?>" class="btn btn-secondary">✏️ Edit Aset</a>
                <a href="<?php echo e(route('dashboard.assets.duplicate', $asset)); ?>" class="btn btn-secondary">📋 Duplikat</a>
                <button onclick="showQRModal(<?php echo e($asset->id); ?>, '<?php echo e($asset->name); ?>', '<?php echo e($asset->instrument_type); ?>', '<?php echo e($asset->location); ?>', '<?php echo e($asset->qr_code); ?>')" class="btn btn-primary">📱 QR Code</button>
            </div>
        </div>

        <!-- Status Badge -->
        <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
            <?php
                $statusConfig = [
                    'Ready' => ['icon' => '✅', 'color' => '#D1FAE5', 'textColor' => '#065F46'],
                    'Washing' => ['icon' => '🧼', 'color' => '#DBEAFE', 'textColor' => '#1E40AF'],
                    'Sterilizing' => ['icon' => '🔥', 'color' => '#DBEAFE', 'textColor' => '#1E40AF'],
                    'In Use' => ['icon' => '🔄', 'color' => '#E5E7EB', 'textColor' => '#374151'],
                    'Maintenance' => ['icon' => '🔧', 'color' => '#FEF3C7', 'textColor' => '#92400E'],
                    'In Transit' => ['icon' => '🚚', 'color' => '#F3E8FF', 'textColor' => '#6B21A8'],
                    'In Transit (Sterile)' => ['icon' => '🚚', 'color' => '#F3E8FF', 'textColor' => '#6B21A8'],
                    'In Transit (Dirty)' => ['icon' => '🚚', 'color' => '#F3E8FF', 'textColor' => '#6B21A8'],
                    'In Process' => ['icon' => '⚙️', 'color' => '#FED7D7', 'textColor' => '#C53030'],
                    'Returning' => ['icon' => '↩️', 'color' => '#C6F6D5', 'textColor' => '#22543D'],
                    'Returned' => ['icon' => '✅', 'color' => '#C6F6D5', 'textColor' => '#22543D'],
                ];
                $config = $statusConfig[$asset->status] ?? ['icon' => '❓', 'color' => '#F7FAFC', 'textColor' => '#2D3748'];
            ?>
            <span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: <?php echo e($config['color']); ?>; color: <?php echo e($config['textColor']); ?>; display: inline-flex; align-items: center; gap: 0.25rem;">
                <span><?php echo e($config['icon']); ?></span>
                <?php echo e($asset->status); ?>

            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Main Content -->
        <div>
            <!-- Asset Information -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Informasi Aset</h3>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Tipe Instrumen</label>
                            <p style="margin: 0; color: var(--gray-900);"><?php echo e($asset->instrument_type); ?></p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Unit</label>
                            <p style="margin: 0; color: var(--gray-900);"><?php echo e($asset->unit); ?> <span style="color: var(--gray-500);">(<?php echo e($asset->unit_code); ?>)</span></p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Lokasi</label>
                            <p style="margin: 0; color: var(--gray-900);"><?php echo e($asset->location); ?></p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Jumlah Total</label>
                            <p style="margin: 0; color: var(--gray-900); font-weight: 600;"><?php echo e($asset->jumlah); ?></p>
                        </div>
                        <?php if($asset->destination_unit): ?>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Unit Tujuan</label>
                            <p style="margin: 0; color: var(--gray-900);"><?php echo e($asset->destination_unit); ?> <span style="color: var(--gray-500);">(<?php echo e($asset->destination_unit_code); ?>)</span></p>
                        </div>
                        <?php endif; ?>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Dibuat</label>
                            <p style="margin: 0; color: var(--gray-900);"><?php echo e($asset->created_at->format('d M Y, H:i')); ?></p>
                        </div>
                    </div>

                    <?php if($asset->description): ?>
                    <div style="margin-top: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Deskripsi</label>
                        <p style="margin: 0; color: var(--gray-900);"><?php echo e($asset->description); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Stock Distribution -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Distribusi Stok</h3>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                        <div style="text-align: center; padding: 1rem; border: 1px solid #10B981; border-radius: 0.5rem; background-color: #F0FDF4;">
                            <div style="font-size: 2rem; color: #10B981; margin-bottom: 0.5rem;">🧴</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: #065F46;"><?php echo e($asset->jumlah_steril); ?></div>
                            <div style="font-size: 0.875rem; color: #047857;">Steril</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; border: 1px solid #F59E0B; border-radius: 0.5rem; background-color: #FFFBEB;">
                            <div style="font-size: 2rem; color: #F59E0B; margin-bottom: 0.5rem;">🧽</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: #92400E;"><?php echo e($asset->jumlah_kotor); ?></div>
                            <div style="font-size: 0.875rem; color: #78350F;">Kotor</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; border: 1px solid #6B7280; border-radius: 0.5rem; background-color: #F9FAFB;">
                            <div style="font-size: 2rem; color: #6B7280; margin-bottom: 0.5rem;">⚙️</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: #374151;"><?php echo e($asset->jumlah_proses_cssd); ?></div>
                            <div style="font-size: 0.875rem; color: #4B5563;">Proses CSSD</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            <?php if($asset->specifications && count($asset->specifications) > 0): ?>
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Spesifikasi</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        <?php $__currentLoopData = $asset->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span style="padding: 0.25rem 0.75rem; background-color: var(--gray-100); color: var(--gray-800); border-radius: 9999px; font-size: 0.875rem;">
                                <?php echo e($spec); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Scan History -->
            <?php if($scanHistory->count() > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Riwayat Scan</h3>
                </div>
                <div class="card-body">
                    <div style="space-y: 1rem;">
                        <?php $__currentLoopData = $scanHistory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.5rem;">
                            <div>
                                <div style="font-weight: 500; color: var(--gray-900);"><?php echo e($scan->user->name ?? 'Unknown User'); ?></div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);"><?php echo e($scan->created_at->format('d M Y, H:i')); ?></div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.875rem; color: var(--gray-600);"><?php echo e($scan->action ?? 'Scanned'); ?></div>
                                <div style="font-size: 0.75rem; color: var(--gray-400);"><?php echo e($scan->location ?? $asset->location); ?></div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- QR Code Preview -->
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Kode QR</h3>
                </div>
                <div class="card-body" style="text-align: center;">
                    <div id="qrPreview" style="margin-bottom: 1rem;"></div>
                    <p style="font-size: 0.875rem; color: var(--gray-600); font-family: monospace; margin-bottom: 1rem;"><?php echo e($asset->qr_code); ?></p>
                    <button onclick="downloadQR()" class="btn btn-primary" style="width: 100%;">📥 Unduh QR</button>
                </div>
            </div>

            <!-- Related Assets -->
            <?php if($relatedAssets->count() > 0): ?>
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Aset Terkait</h3>
                </div>
                <div class="card-body">
                    <div style="space-y: 1rem;">
                        <?php $__currentLoopData = $relatedAssets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('dashboard.assets.show', $related)); ?>" style="display: block; padding: 0.75rem; border: 1px solid var(--gray-200); border-radius: 0.5rem; text-decoration: none; color: inherit; transition: all 0.2s;">
                            <div style="font-weight: 500; color: var(--gray-900); margin-bottom: 0.25rem;"><?php echo e($related->name); ?></div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);"><?php echo e($related->instrument_type); ?></div>
                            <div style="font-size: 0.75rem; color: var(--gray-500);"><?php echo e($related->unit); ?></div>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- QR Code Modal -->
<div id="qrModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
    <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 90%; max-width: 500px; border-radius: 8px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: var(--gray-900);">Kode QR</h3>
            <span class="close" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
        </div>
        <div style="text-align: center;">
            <div id="qrCodeContainer" style="margin-bottom: 20px;"></div>
            <div id="qrInfo" style="margin-bottom: 20px;">
                <p><strong>Nama:</strong> <span id="qrName"></span></p>
                <p><strong>Tipe:</strong> <span id="qrType"></span></p>
                <p><strong>Lokasi:</strong> <span id="qrLocation"></span></p>
                <p><strong>Kode QR:</strong> <span id="qrCodeText"></span></p>
            </div>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button onclick="downloadQR()" class="btn btn-primary">Unduh QR</button>
                <button onclick="printQR()" class="btn btn-secondary">Cetak QR</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure QRCode library is loaded
    if (typeof QRCode === 'undefined') {
        console.error('QRCode library not loaded');
        return;
    }

    // Generate QR code preview
    const qrData = {
        id: <?php echo e($asset->id); ?>,
        name: '<?php echo e($asset->name); ?>',
        instrument_type: '<?php echo e($asset->instrument_type); ?>',
        location: '<?php echo e($asset->location); ?>',
        qr_code: '<?php echo e($asset->qr_code); ?>',
        timestamp: new Date().toISOString()
    };

    const container = document.getElementById('qrPreview');
    const canvas = document.createElement('canvas');
    canvas.width = 150;
    canvas.height = 150;
    container.appendChild(canvas);

    QRCode.toCanvas(canvas, JSON.stringify(qrData), {
        width: 150,
        height: 150,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    }).then(() => {
        console.log('QR Code preview generated successfully');
    }).catch(error => {
        console.error('Error generating QR Code preview:', error);
        container.innerHTML = '<p style="color: red; font-size: 0.875rem;">Error generating QR Code</p>';
    });
});

let currentQRCanvas = null;

function showQRModal(id, name, type, location, qrCode) {
    document.getElementById('qrName').textContent = name;
    document.getElementById('qrType').textContent = type;
    document.getElementById('qrLocation').textContent = location;
    document.getElementById('qrCodeText').textContent = qrCode;

    const qrData = {
        id: id,
        name: name,
        instrument_type: type,
        location: location,
        qr_code: qrCode,
        timestamp: new Date().toISOString()
    };

    const container = document.getElementById('qrCodeContainer');
    container.innerHTML = '';

    const canvas = document.createElement('canvas');
    canvas.width = 200;
    canvas.height = 200;
    container.appendChild(canvas);

    QRCode.toCanvas(canvas, JSON.stringify(qrData), {
        width: 200,
        height: 200,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    }).then(() => {
        currentQRCanvas = canvas;
        console.log('QR Code generated successfully');
    }).catch(error => {
        console.error('Error generating QR Code:', error);
        container.innerHTML = '<p style="color: red;">Error generating QR Code</p>';
    });

    document.getElementById('qrModal').style.display = 'block';
}

// Close modal when clicking the close button
document.querySelector('.close').onclick = function() {
    document.getElementById('qrModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('qrModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

function downloadQR() {
    if (currentQRCanvas) {
        const link = document.createElement('a');
        link.download = 'asset-qr-<?php echo e($asset->qr_code); ?>.png';
        link.href = currentQRCanvas.toDataURL();
        link.click();
    }
}

function printQR() {
    if (currentQRCanvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write('<h2><?php echo e($asset->name); ?></h2>');
        printWindow.document.write('<p>Kode QR: <?php echo e($asset->qr_code); ?></p>');
        printWindow.document.write('<img src="' + currentQRCanvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('<p>Tipe: <?php echo e($asset->instrument_type); ?></p>');
        printWindow.document.write('<p>Lokasi: <?php echo e($asset->location); ?></p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}
</script>

<style>
.card {
    border: 1px solid var(--gray-200);
    border-radius: 0.75rem;
    background: white;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background-color: var(--gray-50);
}

.card-body {
    padding: 1.5rem;
}

.modal-content {
    animation: modalopen 0.3s;
}

@keyframes modalopen {
    from {opacity: 0; transform: translateY(-50px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/assets/show.blade.php ENDPATH**/ ?>