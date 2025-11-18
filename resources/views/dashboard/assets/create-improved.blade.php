@extends('layouts.app')

@section('title', 'Tambah Aset Baru - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Tambah Aset Baru</h1>
        <p style="color: var(--gray-600);">Buat aset instrumen atau peralatan baru dengan mudah</p>
    </div>

    <!-- Quick Templates -->
    <div class="card" style="margin-bottom: 2rem; border: 2px solid var(--primary-color); background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);">
        <div class="card-body">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--primary-color); margin-bottom: 1rem; display: flex; align-items: center;">
                🚀 Template Cepat - Pilih untuk Isi Otomatis
            </h3>
            <p style="color: var(--gray-600); margin-bottom: 1rem;">Klik template di bawah untuk mengisi form secara otomatis</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem;">
                @foreach($templates as $templateName => $templateData)
                    <a href="{{ route('dashboard.assets.create', ['template' => $templateName]) }}"
                       class="template-card"
                       style="display: block; padding: 1.25rem; border: 2px solid var(--gray-200); border-radius: 0.75rem; text-decoration: none; transition: all 0.3s; background: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <div style="font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem; font-size: 1.1rem;">{{ $templateName }}</div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">📋 {{ $templateData['instrument_type'] }}</div>
                        <div style="font-size: 0.75rem; color: var(--primary-color); font-weight: 500;">📦 Jumlah: {{ $templateData['jumlah'] }} unit</div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.assets.store') }}">
                @csrf

                <!-- Basic Information Section -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background: #f8f9fa; border-radius: 0.5rem; border-left: 4px solid var(--primary-color);">
                    <h4 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem; display: flex; align-items: center;">
                        📝 Informasi Dasar
                        <span style="font-size: 0.75rem; font-weight: 400; color: var(--gray-600); margin-left: 0.5rem;">(Wajib diisi)</span>
                    </h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="name" class="form-label" style="font-weight: 500;">Nama Aset</label>
                            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $templateData['name'] ?? '') }}" autocomplete="name" required list="asset-suggestions" placeholder="Contoh: Surgical Scissors">
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Nama instrumen atau peralatan</small>
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
                            <label for="instrument_type" class="form-label" style="font-weight: 500;">Tipe Instrumen</label>
                            <select id="instrument_type" name="instrument_type" class="form-input" autocomplete="off" required>
                                <option value="">Pilih Tipe Instrumen</option>
                                @foreach($instrumentTypes as $type)
                                    <option value="{{ $type->name }}" {{ old('instrument_type', $templateData['instrument_type'] ?? '') === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Kategori instrumen</small>
                            @error('instrument_type')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jumlah" class="form-label" style="font-weight: 500;">Jumlah Total</label>
                            <input type="number" id="jumlah" name="jumlah" class="form-input" value="{{ old('jumlah', $templateData['jumlah'] ?? 1) }}" min="1" autocomplete="off" required>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Berapa banyak unit yang akan dibuat?</small>
                            @error('jumlah')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="location" class="form-label" style="font-weight: 500;">Lokasi Penyimpanan</label>
                            <select id="location" name="location" class="form-input" autocomplete="off" required>
                                <option value="">Pilih Lokasi</option>
                                @foreach($locations as $location)
                                    <option value="{{ $location->name }}" {{ old('location') === $location->name ? 'selected' : '' }}>{{ $location->name }}</option>
                                @endforeach
                            </select>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Dimana aset akan disimpan?</small>
                            @error('location')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Unit Information Section -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background: #fff3cd; border-radius: 0.5rem; border-left: 4px solid #ffc107;">
                    <h4 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem; display: flex; align-items: center;">
                        🏥 Informasi Unit
                        <span style="font-size: 0.75rem; font-weight: 400; color: var(--gray-600); margin-left: 0.5rem;">(Unit asal dan tujuan)</span>
                    </h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="unit" class="form-label" style="font-weight: 500;">Unit Asal</label>
                            <select id="unit" name="unit" class="form-input" autocomplete="off" required>
                                <option value="">Pilih Unit Asal</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->name }}" data-code="{{ $unit->code }}" {{ old('unit') === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Unit yang memiliki aset ini</small>
                            @error('unit')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="unit_code" class="form-label" style="font-weight: 500;">Kode Unit Asal</label>
                            <input type="text" id="unit_code" name="unit_code" class="form-input" value="{{ old('unit_code') }}" autocomplete="off" readonly required placeholder="Otomatis terisi">
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Kode unit (otomatis)</small>
                            @error('unit_code')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="destination_unit" class="form-label" style="font-weight: 500;">Unit Tujuan <small style="color: var(--gray-500);">(Opsional)</small></label>
                            <select id="destination_unit" name="destination_unit" class="form-input" autocomplete="off">
                                <option value="">Pilih Unit Tujuan</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->name }}" data-code="{{ $unit->code }}" {{ old('destination_unit') === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                                @endforeach
                            </select>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Unit tujuan distribusi</small>
                            @error('destination_unit')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="destination_unit_code" class="form-label" style="font-weight: 500;">Kode Unit Tujuan</label>
                            <input type="text" id="destination_unit_code" name="destination_unit_code" class="form-input" value="{{ old('destination_unit_code') }}" autocomplete="off" readonly placeholder="Otomatis terisi">
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Kode unit tujuan (otomatis)</small>
                            @error('destination_unit_code')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Stock Distribution Section -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background: #d1ecf1; border-radius: 0.5rem; border-left: 4px solid #17a2b8;">
                    <h4 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem; display: flex; align-items: center;">
                        📦 Kondisi Stok Awal
                        <span style="font-size: 0.75rem; font-weight: 400; color: var(--gray-600); margin-left: 0.5rem;">(Bagaimana kondisi aset saat ini?)</span>
                    </h4>

                    <div style="margin-bottom: 1rem; padding: 1rem; background: white; border-radius: 0.5rem; border: 1px solid var(--gray-200);">
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                            <div style="text-align: center; padding: 1rem; background: #d4edda; border-radius: 0.5rem; border: 2px solid #c3e6cb;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">✨</div>
                                <div style="font-weight: 600; color: #155724; margin-bottom: 0.25rem;">Stok Steril</div>
                                <div style="font-size: 0.875rem; color: #155724;">Siap digunakan/distribusi</div>
                                <input type="number" id="jumlah_steril" name="jumlah_steril" class="form-input" style="margin-top: 0.5rem; text-align: center; font-weight: 600;" value="{{ old('jumlah_steril', $templateData['jumlah_steril'] ?? old('jumlah', 1)) }}" min="0" autocomplete="off" required>
                            </div>

                            <div style="text-align: center; padding: 1rem; background: #f8d7da; border-radius: 0.5rem; border: 2px solid #f5c6cb;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🧽</div>
                                <div style="font-weight: 600; color: #721c24; margin-bottom: 0.25rem;">Stok Kotor</div>
                                <div style="font-size: 0.875rem; color: #721c24;">Bekas pakai, perlu dicuci</div>
                                <input type="number" id="jumlah_kotor" name="jumlah_kotor" class="form-input" style="margin-top: 0.5rem; text-align: center; font-weight: 600;" value="{{ old('jumlah_kotor', $templateData['jumlah_kotor'] ?? 0) }}" min="0" autocomplete="off" required>
                            </div>

                            <div style="text-align: center; padding: 1rem; background: #fff3cd; border-radius: 0.5rem; border: 2px solid #ffeaa7;">
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔄</div>
                                <div style="font-weight: 600; color: #856404; margin-bottom: 0.25rem;">Proses CSSD</div>
                                <div style="font-size: 0.875rem; color: #856404;">Sedang diproses sterilisasi</div>
                                <input type="number" id="jumlah_proses_cssd" name="jumlah_proses_cssd" class="form-input" style="margin-top: 0.5rem; text-align: center; font-weight: 600;" value="{{ old('jumlah_proses_cssd', $templateData['jumlah_proses_cssd'] ?? 0) }}" min="0" autocomplete="off" required>
                            </div>
                        </div>

                        <div style="margin-top: 1rem; padding: 1rem; background: #f8f9fa; border-radius: 0.5rem; border: 2px solid var(--gray-300);">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong style="color: var(--gray-700);">Total Stok:</strong>
                                    <span id="stock-total" style="font-size: 1.25rem; font-weight: 700; color: var(--primary-color);">0</span>
                                    <span style="color: var(--gray-600);">/</span>
                                    <span id="total-jumlah" style="font-size: 1.25rem; font-weight: 700; color: var(--gray-700);">{{ $templateData['jumlah'] ?? old('jumlah', 1) }}</span>
                                </div>
                                <div id="stock-status" style="padding: 0.5rem 1rem; border-radius: 0.25rem; font-weight: 500;">
                                    <span id="stock-warning" style="color: #dc3545; display: none;">⚠️ Total tidak sesuai!</span>
                                    <span id="stock-success" style="color: #28a745; display: none;">✅ Total sesuai</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('stock_total')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                    @error('stock_negative')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                    @error('stock_exceed')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status and Description Section -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background: #f8f9fa; border-radius: 0.5rem; border-left: 4px solid var(--gray-400);">
                    <h4 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem; display: flex; align-items: center;">
                        📋 Detail Tambahan
                        <span style="font-size: 0.75rem; font-weight: 400; color: var(--gray-600); margin-left: 0.5rem;">(Opsional)</span>
                    </h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div class="form-group">
                            <label for="status" class="form-label" style="font-weight: 500;">Status Awal</label>
                            <select id="status" name="status" class="form-input" autocomplete="off" required>
                                <option value="Ready" {{ old('status', 'Ready') === 'Ready' ? 'selected' : '' }}>Ready - Siap Digunakan</option>
                                <option value="Washing" {{ old('status') === 'Washing' ? 'selected' : '' }}>Washing - Sedang Dicuci</option>
                                <option value="Sterilizing" {{ old('status') === 'Sterilizing' ? 'selected' : '' }}>Sterilizing - Sedang Disterilkan</option>
                                <option value="In Use" {{ old('status') === 'In Use' ? 'selected' : '' }}>In Use - Sedang Digunakan</option>
                                <option value="Maintenance" {{ old('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance - Perbaikan</option>
                                <option value="In Transit" {{ old('status') === 'In Transit' ? 'selected' : '' }}>In Transit - Dalam Pengiriman</option>
                            </select>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Status kondisi aset saat ini</small>
                            @error('status')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" style="grid-column: span 2;">
                            <label for="description" class="form-label" style="font-weight: 500;">Deskripsi Tambahan</label>
                            <textarea id="description" name="description" class="form-input" rows="3" placeholder="Tambahkan catatan khusus tentang aset ini (opsional)" autocomplete="off">{{ old('description') }}</textarea>
                            <small style="color: var(--gray-500); font-size: 0.75rem;">Informasi tambahan seperti spesifikasi, catatan khusus, dll.</small>
                            @error('description')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="margin-top: 2rem; padding: 1.5rem; background: white; border-radius: 0.5rem; border: 2px solid var(--gray-200);">
                    <div style="display: flex; gap: 1rem; justify-content: space-between; align-items: center;">
                        <div style="display: flex; gap: 1rem;">
                            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem; font-weight: 600;">
                                ✅ Buat Aset
                            </button>
                            <button type="button" id="previewBtn" class="btn btn-info" style="padding: 0.75rem 1.5rem;">
                                👁️ Preview QR
                            </button>
                        </div>
                        <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary" style="padding: 0.75rem 2rem;">
                            ❌ Batal
                        </a>
                    </div>
                    <div style="margin-top: 1rem; text-align: center;">
                        <small style="color: var(--gray-500);">Setelah membuat aset, sistem akan otomatis generate QR code unik untuk setiap unit</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.template-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    border-color: var(--primary-color) !important;
}

.form-input {
    padding: 0.75rem;
    border: 2px solid var(--gray-300);
    border-radius: 0.5rem;
    font-size: 1rem;
    transition: border-color 0.2s;
}

.form-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background: #0056b3;
    border-color: #0056b3;
    transform: translateY(-1px);
}

.btn-info {
    background: #17a2b8;
    border-color: #17a2b8;
}

.btn-info:hover {
    background: #138496;
    border-color: #138496;
}

.btn-secondary {
    background: var(--gray-500);
    border-color: var(--gray-500);
}

.btn-secondary:hover {
    background: var(--gray-600);
    border-color: var(--gray-600);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jumlahInput = document.getElementById('jumlah');
    const jumlahSterilInput = document.getElementById('jumlah_steril');
    const jumlahKotorInput = document.getElementById('jumlah_kotor');
    const jumlahProsesCssdInput = document.getElementById('jumlah_proses_cssd');
    const stockTotalSpan = document.getElementById('stock-total');
    const totalJumlahSpan = document.getElementById('total-jumlah');
    const stockWarning = document.getElementById('stock-warning');
    const stockSuccess = document.getElementById('stock-success');
    const stockStatus = document.getElementById('stock-status');

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
            stockSuccess.style.display = 'none';
            stockStatus.style.backgroundColor = '#f8d7da';
            stockStatus.style.border = '1px solid #f5c6cb';
        } else {
            stockWarning.style.display = 'none';
            stockSuccess.style.display = 'inline';
            stockStatus.style.backgroundColor = '#d4edda';
            stockStatus.style.border = '1px solid #c3e6cb';
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
            alert('Harap isi Unit dan Lokasi terlebih dahulu untuk melihat preview QR code');
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
            <div style="background: white; padding: 2rem; border-radius: 0.75rem; max-width: 450px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📱</div>
                    <h3 style="margin-bottom: 0.5rem; color: var(--gray-900);">Preview Kode QR</h3>
                    <p style="color: var(--gray-600); margin-bottom: 1rem;">Ini adalah contoh QR code yang akan dihasilkan</p>
                </div>
                <div style="text-align: center; margin-bottom: 1.5rem;">
                    <div id="qr-preview" style="font-family: 'Courier New', monospace; font-size: 1.4rem; font-weight: 700; padding: 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 0.5rem; margin-bottom: 1rem; letter-spacing: 2px;">
                        ${qrCode}
                    </div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">
                        <strong>Unit:</strong> ${document.getElementById('unit').options[document.getElementById('unit').selectedIndex].text}<br>
                        <strong>Lokasi:</strong> ${document.getElementById('location').options[document.getElementById('location').selectedIndex].text}
                    </div>
                </div>
                <div style="text-align: center; background: #f8f9fa; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <small style="color: var(--gray-600);">
                        💡 <strong>Catatan:</strong> Setiap unit aset akan mendapat QR code unik. Jika jumlah > 1, sistem akan generate QR code yang berbeda untuk setiap unit.
                    </small>
                </div>
                <div style="text-align: right;">
                    <button onclick="this.closest('.modal').remove()" class="btn btn-secondary" style="padding: 0.5rem 1.5rem;">Tutup</button>
                </div>
            </div>
        `;

        modal.className = 'modal';
        document.body.appendChild(modal);
    }
});
</script>
@endsection
