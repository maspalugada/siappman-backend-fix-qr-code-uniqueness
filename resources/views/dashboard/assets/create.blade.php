@extends('layouts.app')

@section('title', 'Add New Asset - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Tambah Aset Baru</h1>
        <p style="color: var(--gray-600);">Buat aset instrumen atau peralatan baru</p>
    </div>

    <!-- Template Selection -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-body">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Template Cepat</h3>
            <p style="color: var(--gray-600); margin-bottom: 1rem;">Pilih template untuk mengisi form secara otomatis</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                @foreach($templates as $templateName => $templateData)
                    <a href="{{ route('dashboard.assets.create', ['template' => $templateName]) }}"
                       class="template-card"
                       style="display: block; padding: 1rem; border: 2px solid var(--gray-200); border-radius: 0.5rem; text-decoration: none; transition: all 0.2s; background: white;">
                        <div style="font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">{{ $templateName }}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $templateData['instrument_type'] }}</div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); margin-top: 0.25rem;">Jumlah: {{ $templateData['jumlah'] }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.assets.store') }}">
                @csrf

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Aset *</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $templateData['name'] ?? '') }}" autocomplete="name" required list="asset-suggestions">
                        <datalist id="asset-suggestions">
                            <option value="Surgical Scissors">
                            <option value="Surgical Forceps">
                            <option value="Surgical Needle Holder">
                            <option value="Surgical Retractor">
                            <option value="Surgical Clamp">
                            <option value="Surgical Probe">
                            <option value="Pressure Gauge">
                            <option value="Temperature Sensor">
                            <option value="Flow Meter">
                            <option value="Level Transmitter">
                            <option value="Control Valve">
                            <option value="Pump">
                            <option value="Motor">
                            <option value="Switch">
                            <option value="Transducer">
                            <option value="Analyzer">
                        </datalist>
                        @error('name')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="instrument_type" class="form-label">Tipe Instrumen *</label>
                        <select id="instrument_type" name="instrument_type" class="form-input" autocomplete="off" required>
                            <option value="">Pilih Tipe Instrumen</option>
                            @foreach($instrumentTypes as $type)
                                <option value="{{ $type->name }}" {{ old('instrument_type', $templateData['instrument_type'] ?? '') === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('instrument_type')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit" class="form-label">Unit Awal *</label>
                        <select id="unit" name="unit" class="form-input" autocomplete="off" required>
                            <option value="">Pilih Unit Awal</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->name }}" data-code="{{ $unit->code }}" {{ old('unit') === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('unit')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit_code" class="form-label">Kode Unit Awal *</label>
                        <input type="text" id="unit_code" name="unit_code" class="form-input" value="{{ old('unit_code') }}" autocomplete="off" readonly required>
                        @error('unit_code')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="destination_unit" class="form-label">Unit Tujuan</label>
                        <select id="destination_unit" name="destination_unit" class="form-input" autocomplete="off">
                            <option value="">Pilih Unit Tujuan</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->name }}" data-code="{{ $unit->code }}" {{ old('destination_unit') === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_unit')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="destination_unit_code" class="form-label">Kode Unit Tujuan</label>
                        <input type="text" id="destination_unit_code" name="destination_unit_code" class="form-input" value="{{ old('destination_unit_code') }}" autocomplete="off" readonly>
                        @error('destination_unit_code')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah" class="form-label">Jumlah Total *</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-input" value="{{ old('jumlah', $templateData['jumlah'] ?? 1) }}" min="1" autocomplete="off" required>
                        @error('jumlah')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Distribusi Stok Awal</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.5rem;">
                            <div>
                                <label for="jumlah_steril" class="form-label" style="font-size: 0.875rem; font-weight: 500;">Stok Steril (Siap Distribusi)</label>
                                <input type="number" id="jumlah_steril" name="jumlah_steril" class="form-input" value="{{ old('jumlah_steril', $templateData['jumlah_steril'] ?? old('jumlah', 1)) }}" min="0" autocomplete="off" required>
                                @error('jumlah_steril')
                                    <div style="color: var(--error); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="jumlah_kotor" class="form-label" style="font-size: 0.875rem; font-weight: 500;">Stok Kotor (Bekas Pakai)</label>
                                <input type="number" id="jumlah_kotor" name="jumlah_kotor" class="form-input" value="{{ old('jumlah_kotor', $templateData['jumlah_kotor'] ?? 0) }}" min="0" autocomplete="off" required>
                                @error('jumlah_kotor')
                                    <div style="color: var(--error); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="jumlah_proses_cssd" class="form-label" style="font-size: 0.875rem; font-weight: 500;">Stok Proses CSSD</label>
                                <input type="number" id="jumlah_proses_cssd" name="jumlah_proses_cssd" class="form-input" value="{{ old('jumlah_proses_cssd', $templateData['jumlah_proses_cssd'] ?? 0) }}" min="0" autocomplete="off" required>
                                @error('jumlah_proses_cssd')
                                    <div style="color: var(--error); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div style="margin-top: 0.5rem; padding: 0.5rem; background-color: var(--gray-50); border-radius: 0.25rem; border: 1px solid var(--gray-200);">
                            <small style="color: var(--gray-600); font-size: 0.75rem;">
                                <strong>Total harus sama dengan Jumlah Total:</strong>
                                <span id="stock-total">0</span> / <span id="total-jumlah">{{ $templateData['jumlah'] ?? old('jumlah', 1) }}</span>
                                <span id="stock-warning" style="color: var(--error); display: none;">⚠️ Total stok tidak sesuai!</span>
                            </small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Lokasi *</label>
                        <select id="location" name="location" class="form-input" autocomplete="off" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}" {{ old('location') === $location->name ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error('location')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select id="status" name="status" class="form-input" autocomplete="off" required>
                            <option value="">Pilih Status</option>
                            <option value="Ready" {{ old('status', 'Ready') === 'Ready' ? 'selected' : '' }}>Ready</option>
                            <option value="Washing" {{ old('status') === 'Washing' ? 'selected' : '' }}>Washing</option>
                            <option value="Sterilizing" {{ old('status') === 'Sterilizing' ? 'selected' : '' }}>Sterilizing</option>
                            <option value="In Use" {{ old('status') === 'In Use' ? 'selected' : '' }}>In Use</option>
                            <option value="Maintenance" {{ old('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="In Transit" {{ old('status') === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="In Transit (Sterile)" {{ old('status') === 'In Transit (Sterile)' ? 'selected' : '' }}>In Transit (Sterile)</option>
                            <option value="In Transit (Dirty)" {{ old('status') === 'In Transit (Dirty)' ? 'selected' : '' }}>In Transit (Dirty)</option>
                            <option value="In Process" {{ old('status') === 'In Process' ? 'selected' : '' }}>In Process</option>
                            <option value="Returning" {{ old('status') === 'Returning' ? 'selected' : '' }}>Returning</option>
                            <option value="Returned" {{ old('status') === 'Returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                        @error('status')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-input" rows="4" placeholder="Deskripsi opsional untuk aset ini" autocomplete="off">{{ old('description') }}</textarea>
                    @error('description')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Buat Aset</button>
                    <button type="button" id="previewBtn" class="btn btn-info">👁️ Preview QR</button>
                    <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah');
    const jumlahSterilInput = document.getElementById('jumlah_steril');
    const jumlahKotorInput = document.getElementById('jumlah_kotor');
    const jumlahProsesCssdInput = document.getElementById('jumlah_proses_cssd');
    const stockTotalSpan = document.getElementById('stock-total');
    const totalJumlahSpan = document.getElementById('total-jumlah');
    const stockWarning = document.getElementById('stock-warning');

    function updateStockTotal() {
        const steril = parseInt(jumlahSterilInput.value) || 0;
        const kotor = parseInt(jumlahKotorInput.value) || 0;
        const proses = parseInt(jumlahProsesCssdInput.value) || 0;
        const total = steril + kotor + proses;
        const required = parseInt(jumlahInput.value) || 0;

        stockTotalSpan.textContent = total;
        totalJumlahSpan.textContent = required;

        if (total !== required) {
            stockWarning.style.display = 'inline';
        } else {
            stockWarning.style.display = 'none';
        }
    }

    function updateDefaultStock() {
        const jumlah = parseInt(jumlahInput.value) || 0;
        if (jumlah > 0 && parseInt(jumlahSterilInput.value) === 0 && !@json($templateData)) {
            jumlahSterilInput.value = jumlah;
            updateStockTotal();
        }
    }

    function updateMaxValues() {
        const max = parseInt(jumlahInput.value) || 0;
        jumlahSterilInput.max = max;
        jumlahKotorInput.max = max;
        jumlahProsesCssdInput.max = max;
    }

    jumlahInput.addEventListener('input', function() {
        updateMaxValues();
        updateDefaultStock();
        updateStockTotal();
    });

    jumlahSterilInput.addEventListener('input', updateStockTotal);
    jumlahKotorInput.addEventListener('input', updateStockTotal);
    jumlahProsesCssdInput.addEventListener('input', updateStockTotal);

    // Initial calculation
    updateMaxValues();
    updateStockTotal();

    // Unit code auto-fill functionality
    document.getElementById('unit').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const code = selectedOption.getAttribute('data-code');
        document.getElementById('unit_code').value = code || '';
    });

    document.getElementById('destination_unit').addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const code = selectedOption.getAttribute('data-code');
        document.getElementById('destination_unit_code').value = code || '';
    });

    // Preview QR functionality
    document.getElementById('previewBtn').addEventListener('click', function() {
        const unitCode = document.getElementById('unit_code').value;
        const location = document.getElementById('location').value;

        if (!unitCode || !location) {
            alert('Harap isi Unit dan Lokasi terlebih dahulu');
            return;
        }

        // Generate preview QR code
        const previewQr = generatePreviewQR(unitCode, location);
        showQRModal(previewQr);
    });

    function generatePreviewQR(unitCode, location) {
        // Simulate QR generation logic
        const locationObj = @json($locations->where('name', $location ?? '')->first());
        const floor = locationObj ? locationObj.floor : '00';
        const sequence = '001'; // Preview sequence

        return `${unitCode.toUpperCase()}-${floor}-${sequence}`;
    }

    function showQRModal(qrCode) {
        // Create modal
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: flex; align-items: center;
            justify-content: center; z-index: 1000;
        `;

        modal.innerHTML = `
            <div style="background: white; padding: 2rem; border-radius: 0.5rem; max-width: 400px; width: 90%;">
                <h3 style="margin-bottom: 1rem;">Preview Kode QR</h3>
                <div style="text-align: center; margin-bottom: 1rem;">
                    <div id="qr-preview" style="font-family: monospace; font-size: 1.2rem; padding: 1rem; background: #f8f9fa; border-radius: 0.25rem; margin-bottom: 1rem;">
                        ${qrCode}
                    </div>
                    <div style="font-size: 0.875rem; color: #6c757d;">
                        Unit: ${document.getElementById('unit').options[document.getElementById('unit').selectedIndex].text}<br>
                        Lokasi: ${document.getElementById('location').options[document.getElementById('location').selectedIndex].text}
                    </div>
                </div>
                <div style="text-align: right;">
                    <button onclick="this.closest('.modal').remove()" class="btn btn-secondary">Tutup</button>
                </div>
            </div>
        `;

        modal.className = 'modal';
        document.body.appendChild(modal);
    }
});
</script>
@endsection
