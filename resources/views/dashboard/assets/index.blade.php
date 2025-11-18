@extends('layouts.app')

@section('title', 'Assets List - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Manajemen Aset</h1>
        <p style="color: var(--gray-600);">Kelola instrumen dan peralatan Anda</p>
        </div>
        <a href="{{ route('dashboard.assets.create') }}" class="btn btn-primary">
            <span style="margin-right: 0.5rem;">+</span>
            Tambah Aset Baru
        </a>
    </div>

    <!-- Search Form -->
    <div style="margin-bottom: 2rem;">
        <form action="{{ route('dashboard.assets.index') }}" method="GET">
            <div style="display: flex; gap: 1rem;">
            <input type="text" name="search" placeholder="Cari berdasarkan nama aset..." value="{{ request('search') }}" style="flex-grow: 1; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
            <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
    </div>

    @if($assets->count() > 0)
        <div class="card">
            <div class="card-body">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 1px solid var(--gray-200);">
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Nama</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Tipe Instrumen</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Unit Awal</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Kode Unit Awal</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Unit Tujuan</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Kode Unit Tujuan</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Jumlah Total</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Stok Steril</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Stok Kotor</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Stok Proses CSSD</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Lokasi</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Status</th>
                                <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900);">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assets as $asset)
                                <tr style="border-bottom: 1px solid var(--gray-100);">
                                    <td style="padding: 1rem; color: var(--gray-900); font-weight: 500;">{{ $asset->name }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->instrument_type }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->unit }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->unit_code }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->destination_unit }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->destination_unit_code }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->jumlah }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->jumlah_steril ?? 0 }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->jumlah_kotor ?? 0 }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->jumlah_proses_cssd ?? 0 }}</td>
                                    <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->location }}</td>
                                    <td style="padding: 1rem;">
                                        @php
                                            $statusClass = '';
                                            switch ($asset->status) {
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
                                                case 'In Transit':
                                                case 'In Transit (Sterile)':
                                                case 'In Transit (Dirty)':
                                                    $statusClass = 'background-color: #F3E8FF; color: #6B21A8;';
                                                    break;
                                                case 'In Process':
                                                    $statusClass = 'background-color: #FED7D7; color: #C53030;';
                                                    break;
                                                case 'Returning':
                                                case 'Returned':
                                                    $statusClass = 'background-color: #C6F6D5; color: #22543D;';
                                                    break;
                                                default:
                                                    $statusClass = 'background-color: #F7FAFC; color: #2D3748;';
                                                    break;
                                            }
                                        @endphp
                                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; {{ $statusClass }}">
                                            {{ $asset->status }}
                                        </span>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="{{ route('dashboard.assets.show', $asset) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Lihat</a>
                                            <a href="{{ route('dashboard.assets.edit', $asset) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">Edit</a>
                                            <button onclick="showQRModal({{ $asset->id }}, '{{ $asset->name }}', '{{ $asset->instrument_type }}', '{{ $asset->location }}', '{{ $asset->qr_code }}')" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">QR</button>
                                            <form method="POST" action="{{ route('dashboard.assets.destroy', $asset) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn" style="padding: 0.5rem 1rem; font-size: 0.875rem; background-color: #EF4444; color: white; border: none; border-radius: 0.5rem;">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($assets->hasPages())
                    <div style="margin-top: 2rem; display: flex; justify-content: center;">
                        {{ $assets->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div style="text-align: center; color: var(--gray-500); padding: 3rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                    <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">Belum Ada Aset</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1.5rem;">Tambahkan aset pertama Anda untuk mulai melacak</p>
                    <a href="{{ route('dashboard.assets.create') }}" class="btn btn-primary">Tambah Aset Pertama Anda</a>
                </div>
            </div>
        </div>
    @endif
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
});
</script>
<script>
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
        link.download = 'asset-qr-' + document.getElementById('qrCodeText').textContent + '.png';
        link.href = currentQRCanvas.toDataURL();
        link.click();
    }
}

function printQR() {
    if (currentQRCanvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write('<h2>' + document.getElementById('qrName').textContent + '</h2>');
        printWindow.document.write('<p>Kode QR: ' + document.getElementById('qrCodeText').textContent + '</p>');
        printWindow.document.write('<img src="' + currentQRCanvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('<p>Tipe: ' + document.getElementById('qrType').textContent + '</p>');
        printWindow.document.write('<p>Lokasi: ' + document.getElementById('qrLocation').textContent + '</p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}
</script>

<style>
.modal-content {
    animation: modalopen 0.3s;
}

@keyframes modalopen {
    from {opacity: 0; transform: translateY(-50px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>
@endsection
