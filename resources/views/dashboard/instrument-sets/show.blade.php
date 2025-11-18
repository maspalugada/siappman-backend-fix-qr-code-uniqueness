@extends('layouts.app')

@section('title', $instrumentSet->name . ' - Instrument Sets - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">{{ $instrumentSet->name }}</h1>
            <p style="color: var(--gray-600);">Set Details</p>
        </div>
        <a href="{{ route('dashboard.instrument-sets.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">QR Code</h3>
                    <div id="qrCodeContainer" style="border: 1px solid var(--gray-200); padding: 1rem; border-radius: 0.5rem; text-align: center;"></div>
                    <p style="text-align: center; margin-top: 1rem; font-family: monospace; color: var(--gray-700);">{{ $instrumentSet->qr_code }}</p>
                    <div style="display: flex; flex-direction: column; gap: 1rem; margin-top: 1rem;">
                        <button onclick="downloadQR()" class="btn btn-primary">Download QR Code</button>
                        <button onclick="printQR()" class="btn btn-secondary">Print QR Code</button>
                    </div>
                </div>
                <div>
                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Details</h3>
                    <p><strong>Status:</strong>
                        @php
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
                        @endphp
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; {{ $statusClass }}">
                            {{ $instrumentSet->status }}
                        </span>
                    </p>
                    <p style="margin-top: 1rem;"><strong>Description:</strong><br>{{ $instrumentSet->description ?? 'N/A' }}</p>
                    <p><strong>Created At:</strong> {{ $instrumentSet->created_at->format('d M Y, H:i') }}</p>

                    <hr style="margin: 2rem 0;">

                    <h3 style="font-weight: 600; margin-bottom: 1rem;">Assets in this Set ({{ $instrumentSet->assets->count() }})</h3>
                    <ul>
                        @forelse($instrumentSet->assets as $asset)
                            <li>{{ $asset->name }} ({{ $asset->instrument_type }})</li>
                        @empty
                            <li>No assets have been added to this set.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/app.js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const qrData = {
        id: {{ $instrumentSet->id }},
        name: '{{ addslashes($instrumentSet->name) }}',
        qr_code: '{{ $instrumentSet->qr_code }}',
        type: 'instrument_set',
        assets_count: {{ $instrumentSet->assets->count() }},
        assets: [
            @foreach($instrumentSet->assets as $asset)
            {
                id: {{ $asset->id }},
                name: '{{ addslashes($asset->name) }}',
                unit: '{{ addslashes($asset->unit) }}',
                location: '{{ addslashes($asset->location) }}',
                instrument_type: '{{ addslashes($asset->instrument_type) }}'
            }@if(!$loop->last),@endif
            @endforeach
        ],
        timestamp: '{{ now()->toISOString() }}'
    };

    const qrContainer = document.getElementById('qrCodeContainer');
    qrContainer.innerHTML = '';

    try {
        const canvas = document.createElement('canvas');
        canvas.width = 200;
        canvas.height = 200;
        qrContainer.appendChild(canvas);

        QRCode.toCanvas(canvas, '{{ $instrumentSet->qr_code }}', {
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
        link.download = 'instrument-set-{{ $instrumentSet->qr_code }}.png';
        link.href = canvas.toDataURL();
        link.click();
    }
}

function printQR() {
    const canvas = document.querySelector('#qrCodeContainer canvas');
    if (canvas) {
        const printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print QR Code</title></head><body style="text-align: center;">');
        printWindow.document.write('<h2>{{ $instrumentSet->name }}</h2>');
        printWindow.document.write('<p>QR Code: {{ $instrumentSet->qr_code }}</p>');
        printWindow.document.write('<img src="' + canvas.toDataURL() + '" style="max-width: 300px;"/>');
        printWindow.document.write('<p>Status: {{ $instrumentSet->status }}</p>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }
}
</script>
@endsection
