<?php $__env->startSection('title', $instrumentSet->name . ' - Instrument Sets - SiAPPMan'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;"><?php echo e($instrumentSet->name); ?></h1>
            <p style="color: var(--gray-600);">Set Details</p>
        </div>
        <a href="<?php echo e(route('dashboard.instrument-sets.index')); ?>" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">QR Code</h3>
                    <div id="qrCodeContainer" style="border: 1px solid var(--gray-200); padding: 1rem; border-radius: 0.5rem; text-align: center;"></div>
                    <p style="text-align: center; margin-top: 1rem; font-family: monospace; color: var(--gray-700);"><?php echo e($instrumentSet->qr_code); ?></p>
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                        <button onclick="downloadQR()" class="btn btn-primary">Download QR Code</button>
                        <button onclick="printQR()" class="btn btn-secondary">Print QR Code</button>
                    </div>
                </div>
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Details</h3>
                    <p><strong>Status:</strong>
                        <?php
                            $statusClass = '';
                            switch ($instrumentSet->status) {
                                case 'Ready':
                                    $statusClass = 'background-color: #D1FAE5; color: #065F46;';
                                    break;
                                case 'Washing':
                                case 'Sterilizing':
                                    $statusClass = 'background-color: #DBEAFE; color: #1E40AF;';
                                    break;
                                case 'In Use':
                                    $statusClass = 'background-color: #E5E7EB; color: #374151;';
                                    break;
                                case 'Maintenance':
                                    $statusClass = 'background-color: #FEF3C7; color: #92400E;';
                                    break;
                            }
                        ?>
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; <?php echo e($statusClass); ?>">
                            <?php echo e($instrumentSet->status); ?>

                        </span>
                    </p>
                    <p style="margin-top: 1rem;"><strong>Description:</strong><br><?php echo e($instrumentSet->description ?? 'N/A'); ?></p>
                    <p><strong>Created At:</strong> <?php echo e($instrumentSet->created_at->format('d M Y, H:i')); ?></p>

                    <hr style="margin: 2rem 0;">

                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Assets in this Set (<?php echo e($instrumentSet->assets->count()); ?>)</h3>
                    <ul>
                        <?php $__empty_1 = true; $__currentLoopData = $instrumentSet->assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li><?php echo e($asset->name); ?> (<?php echo e($asset->instrument_type); ?>)</li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li>No assets have been added to this set.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrData = {
        id: <?php echo e($instrumentSet->id); ?>,
        name: '<?php echo e(addslashes($instrumentSet->name)); ?>',
        qr_code: '<?php echo e($instrumentSet->qr_code); ?>',
        type: 'instrument_set',
        assets_count: <?php echo e($instrumentSet->assets->count()); ?>,
        assets: [
            <?php $__currentLoopData = $instrumentSet->assets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asset): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                id: <?php echo e($asset->id); ?>,
                name: '<?php echo e(addslashes($asset->name)); ?>',
                unit: '<?php echo e(addslashes($asset->unit)); ?>',
                location: '<?php echo e(addslashes($asset->location)); ?>',
                instrument_type: '<?php echo e(addslashes($asset->instrument_type)); ?>'
            }<?php if(!$loop->last): ?>,<?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        timestamp: '<?php echo e(now()->toISOString()); ?>'
    };

    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = '';

    try {
        const canvas = document.createElement('canvas');
        canvas.width = 200;
        canvas.height = 200;
        qrContainer.appendChild(canvas);

        QRCode.toCanvas(canvas, '<?php echo e($instrumentSet->qr_code); ?>', {
            width: 200,
            height: 200,
            color: {
                dark: '#000000',
                light: '#FFFFFF'
            }
        }).then(() => {
            console.log('QR Code generated successfully');
        }).catch(error => {
            console.error('Error generating QR code:', error);
            showFallbackQR(qrContainer, qrData);
        });
    } catch (error) {
        console.error('Error creating QR code:', error);
        showFallbackQR(qrContainer, qrData);
    }

    function showFallbackQR(container, data) {
        container.innerHTML = '<div style="padding: 1rem; background: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">' +
            '<p style="margin: 0 0 0.5rem 0; font-weight: bold; color: #495057;">QR Code Data:</p>' +
            '<pre style="margin: 0; font-family: monospace; font-size: 0.875rem; color: #6c757d; white-space: pre-wrap; word-break: break-all;">' +
            JSON.stringify(data, null, 2) +
            '</pre></div>';
    }
});

function downloadQR() {
    const canvas = document.querySelector('#qrCodeContainer canvas');
    if (canvas) {
        const link = document.createElement('a');
        link.download = 'instrument-set-<?php echo e($instrumentSet->qr_code); ?>.png';
        link.href = canvas.toDataURL();
        link.click();
    }
}

function printQR() {
    const canvas = document.querySelector('#qrCodeContainer canvas');
    if (canvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write('<h2><?php echo e($instrumentSet->name); ?></h2>');
        printWindow.document.write('<p>QR Code: <?php echo e($instrumentSet->qr_code); ?></p>');
        printWindow.document.write('<img src="' + canvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('<p>Status: <?php echo e($instrumentSet->status); ?></p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\siappman-backend-fix-qr-code-uniqueness\resources\views/dashboard/instrument-sets/show.blade.php ENDPATH**/ ?>