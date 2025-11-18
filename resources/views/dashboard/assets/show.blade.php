@extends('layouts.app')

@section('title', $asset->name . ' - Asset Details - SiAPPMan')

@section('content')
<div class="container">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">{{ $asset->name }}</h1>
                <p style="color: var(--gray-600); font-family: monospace;">{{ $asset->qr_code }}</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <a href="{{ route('dashboard.assets.edit', $asset) }}" class="btn btn-secondary">✏️ Edit Aset</a>
                <a href="{{ route('dashboard.assets.duplicate', $asset) }}" class="btn btn-secondary">📋 Duplikat</a>
                <button onclick="showQRModal({{ $asset->id }}, '{{ $asset->name }}', '{{ $asset->instrument_type }}', '{{ $asset->location }}', '{{ $asset->qr_code }}')" class="btn btn-primary">📱 QR Code</button>
            </div>
        </div>

        <!-- Status Badge -->
        <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
            @php
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
            @endphp
            <span style="padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 500; background-color: {{ $config['color'] }}; color: {{ $config['textColor'] }}; display: inline-flex; align-items: center; gap: 0.25rem;">
                <span>{{ $config['icon'] }}</span>
                {{ $asset->status }}
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
                            <p style="margin: 0; color: var(--gray-900);">{{ $asset->instrument_type }}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Unit</label>
                            <p style="margin: 0; color: var(--gray-900);">{{ $asset->unit }} <span style="color: var(--gray-500);">({{ $asset->unit_code }})</span></p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Lokasi</label>
                            <p style="margin: 0; color: var(--gray-900);">{{ $asset->location }}</p>
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Jumlah Total</label>
                            <p style="margin: 0; color: var(--gray-900); font-weight: 600;">{{ $asset->jumlah }}</p>
                        </div>
                        @if($asset->destination_unit)
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Unit Tujuan</label>
                            <p style="margin: 0; color: var(--gray-900);">{{ $asset->destination_unit }} <span style="color: var(--gray-500);">({{ $asset->destination_unit_code }})</span></p>
                        </div>
                        @endif
                        <div>
                            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Dibuat</label>
                            <p style="margin: 0; color: var(--gray-900);">{{ $asset->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if($asset->description)
                    <div style="margin-top: 1.5rem;">
                        <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Deskripsi</label>
                        <p style="margin: 0; color: var(--gray-900);">{{ $asset->description }}</p>
                    </div>
                    @endif
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
                            <div style="font-size: 1.5rem; font-weight: 700; color: #065F46;">{{ $asset->jumlah_steril }}</div>
                            <div style="font-size: 0.875rem; color: #047857;">Steril</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; border: 1px solid #F59E0B; border-radius: 0.5rem; background-color: #FFFBEB;">
                            <div style="font-size: 2rem; color: #F59E0B; margin-bottom: 0.5rem;">🧽</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: #92400E;">{{ $asset->jumlah_kotor }}</div>
                            <div style="font-size: 0.875rem; color: #78350F;">Kotor</div>
                        </div>
                        <div style="text-align: center; padding: 1rem; border: 1px solid #6B7280; border-radius: 0.5rem; background-color: #F9FAFB;">
                            <div style="font-size: 2rem; color: #6B7280; margin-bottom: 0.5rem;">⚙️</div>
                            <div style="font-size: 1.5rem; font-weight: 700; color: #374151;">{{ $asset->jumlah_proses_cssd }}</div>
                            <div style="font-size: 0.875rem; color: #4B5563;">Proses CSSD</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications -->
            @if($asset->specifications && count($asset->specifications) > 0)
            <div class="card" style="margin-bottom: 2rem;">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Spesifikasi</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                        @foreach($asset->specifications as $spec)
                            <span style="padding: 0.25rem 0.75rem; background-color: var(--gray-100); color: var(--gray-800); border-radius: 9999px; font-size: 0.875rem;">
                                {{ $spec }}
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Scan History -->
            @if($scanHistory->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Riwayat Scan</h3>
                </div>
                <div class="card-body">
                    <div style="space-y: 1rem;">
                        @foreach($scanHistory as $scan)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; border: 1px solid var(--gray-200); border-radius: 0.5rem;">
                            <div>
                                <div style="font-weight: 500; color: var(--gray-900);">{{ $scan->user->name ?? 'Unknown User' }}</div>
                                <div style="font-size: 0.875rem; color: var(--gray-500);">{{ $scan->created_at->format('d M Y, H:i') }}</div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $scan->action ?? 'Scanned' }}</div>
                                <div style="font-size: 0.75rem; color: var(--gray-400);">{{ $scan->location ?? $asset->location }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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
                    <p style="font-size: 0.875rem; color: var(--gray-600); font-family: monospace; margin-bottom: 1rem;">{{ $asset->qr_code }}</p>
                    <button onclick="downloadQR()" class="btn btn-primary" style="width: 100%;">📥 Unduh QR</button>
                </div>
            </div>

            <!-- Related Assets -->
            @if($relatedAssets->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h3 style="margin: 0; font-size: 1.25rem; font-weight: 600;">Aset Terkait</h3>
                </div>
                <div class="card-body">
                    <div style="space-y: 1rem;">
                        @foreach($relatedAssets as $related)
                        <a href="{{ route('dashboard.assets.show', $related) }}" style="display: block; padding: 0.75rem; border: 1px solid var(--gray-200); border-radius: 0.5rem; text-decoration: none; color: inherit; transition: all 0.2s;">
                            <div style="font-weight: 500; color: var(--gray-900); margin-bottom: 0.25rem;">{{ $related->name }}</div>
                            <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $related->instrument_type }}</div>
                            <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $related->unit }}</div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
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
        id: {{ $asset->id }},
        name: '{{ $asset->name }}',
        instrument_type: '{{ $asset->instrument_type }}',
        location: '{{ $asset->location }}',
        qr_code: '{{ $asset->qr_code }}',
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
        link.download = 'asset-qr-{{ $asset->qr_code }}.png';
        link.href = currentQRCanvas.toDataURL();
        link.click();
    }
}

function printQR() {
    if (currentQRCanvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write('<h2>{{ $asset->name }}</h2>');
        printWindow.document.write('<p>Kode QR: {{ $asset->qr_code }}</p>');
        printWindow.document.write('<img src="' + currentQRCanvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('<p>Tipe: {{ $asset->instrument_type }}</p>');
        printWindow.document.write('<p>Lokasi: {{ $asset->location }}</p>');
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
@endsection
