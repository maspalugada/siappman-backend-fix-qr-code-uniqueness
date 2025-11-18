@extends('layouts.app')

@section('title', 'Edit Asset - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Edit Aset</h1>
        <p style="color: var(--gray-600);">Perbarui informasi aset</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.assets.update', $asset) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Aset *</label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $asset->name) }}" required>
                        @error('name')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="instrument_type" class="form-label">Tipe Instrumen *</label>
                        <select id="instrument_type" name="instrument_type" class="form-input" required>
                            <option value="">Pilih Tipe Instrumen</option>
                            @foreach($instrumentTypes as $type)
                                <option value="{{ $type->name }}" {{ old('instrument_type', $asset->instrument_type) === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('instrument_type')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit" class="form-label">Unit Awal *</label>
                        <select id="unit" name="unit" class="form-input" required>
                            <option value="">Pilih Unit Awal</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->name }}" data-code="{{ $unit->code }}" {{ old('unit', $asset->unit) === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('unit')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="unit_code" class="form-label">Kode Unit Awal</label>
                        <input type="text" id="unit_code" name="unit_code" class="form-input" value="{{ old('unit_code', $asset->unit_code) }}" autocomplete="off" readonly>
                        @error('unit_code')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="destination_unit" class="form-label">Unit Tujuan</label>
                        <select id="destination_unit" name="destination_unit" class="form-input" autocomplete="off">
                            <option value="">Pilih Unit Tujuan</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->name }}" data-code="{{ $unit->code }}" {{ old('destination_unit', $asset->destination_unit) === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                        @error('destination_unit')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="destination_unit_code" class="form-label">Kode Unit Tujuan</label>
                        <input type="text" id="destination_unit_code" name="destination_unit_code" class="form-input" value="{{ old('destination_unit_code', $asset->destination_unit_code) }}" autocomplete="off" readonly>
                        @error('destination_unit_code')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="jumlah" class="form-label">Jumlah Total *</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-input" value="{{ old('jumlah', $asset->jumlah) }}" min="1" required>
                        @error('jumlah')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label">Distribusi Stok</label>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.5rem;">
                            <div>
                                <label for="jumlah_steril" class="form-label" style="font-size: 0.875rem; font-weight: 500;">Stok Steril (Siap Distribusi)</label>
                                <input type="number" id="jumlah_steril" name="jumlah_steril" class="form-input" value="{{ old('jumlah_steril', $asset->jumlah_steril ?? 0) }}" min="0" required>
                                @error('jumlah_steril')
                                    <div style="color: var(--error); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="jumlah_kotor" class="form-label" style="font-size: 0.875rem; font-weight: 500;">Stok Kotor (Bekas Pakai)</label>
                                <input type="number" id="jumlah_kotor" name="jumlah_kotor" class="form-input" value="{{ old('jumlah_kotor', $asset->jumlah_kotor ?? 0) }}" min="0" required>
                                @error('jumlah_kotor')
                                    <div style="color: var(--error); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label for="jumlah_proses_cssd" class="form-label" style="font-size: 0.875rem; font-weight: 500;">Stok Proses CSSD</label>
                                <input type="number" id="jumlah_proses_cssd" name="jumlah_proses_cssd" class="form-input" value="{{ old('jumlah_proses_cssd', $asset->jumlah_proses_cssd ?? 0) }}" min="0" required>
                                @error('jumlah_proses_cssd')
                                    <div style="color: var(--error); font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div style="margin-top: 0.5rem; padding: 0.5rem; background-color: var(--gray-50); border-radius: 0.25rem; border: 1px solid var(--gray-200);">
                            <small style="color: var(--gray-600); font-size: 0.75rem;">
                                <strong>Total harus sama dengan Jumlah Total:</strong>
                                <span id="stock-total">0</span> / <span id="total-jumlah">{{ old('jumlah', $asset->jumlah) }}</span>
                                <span id="stock-warning" style="color: var(--error); display: none;">⚠️ Total stok tidak sesuai!</span>
                            </small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">Lokasi *</label>
                        <select id="location" name="location" class="form-input" required>
                            <option value="">Pilih Lokasi</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->name }}" {{ old('location', $asset->location) === $location->name ? 'selected' : '' }}>{{ $location->name }}</option>
                            @endforeach
                        </select>
                        @error('location')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status *</label>
                        <select id="status" name="status" class="form-input" required>
                            <option value="">Pilih Status</option>
                            <option value="Ready" {{ old('status', $asset->status) === 'Ready' ? 'selected' : '' }}>Ready</option>
                            <option value="Washing" {{ old('status', $asset->status) === 'Washing' ? 'selected' : '' }}>Washing</option>
                            <option value="Sterilizing" {{ old('status', $asset->status) === 'Sterilizing' ? 'selected' : '' }}>Sterilizing</option>
                            <option value="In Use" {{ old('status', $asset->status) === 'In Use' ? 'selected' : '' }}>In Use</option>
                            <option value="Maintenance" {{ old('status', $asset->status) === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="In Transit" {{ old('status', $asset->status) === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                            <option value="In Transit (Sterile)" {{ old('status', $asset->status) === 'In Transit (Sterile)' ? 'selected' : '' }}>In Transit (Sterile)</option>
                            <option value="In Transit (Dirty)" {{ old('status', $asset->status) === 'In Transit (Dirty)' ? 'selected' : '' }}>In Transit (Dirty)</option>
                            <option value="In Process" {{ old('status', $asset->status) === 'In Process' ? 'selected' : '' }}>In Process</option>
                            <option value="Returning" {{ old('status', $asset->status) === 'Returning' ? 'selected' : '' }}>Returning</option>
                            <option value="Returned" {{ old('status', $asset->status) === 'Returned' ? 'selected' : '' }}>Returned</option>
                        </select>
                        @error('status')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group" style="margin-top: 1.5rem;">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-input" rows="4" placeholder="Deskripsi opsional untuk aset ini">{{ old('description', $asset->description) }}</textarea>
                    @error('description')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Perbarui Aset</button>
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

    function updateMaxValues() {
        const max = parseInt(jumlahInput.value) || 0;
        jumlahSterilInput.max = max;
        jumlahKotorInput.max = max;
        jumlahProsesCssdInput.max = max;
    }

    jumlahInput.addEventListener('input', function() {
        updateMaxValues();
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
});
</script>
@endsection
