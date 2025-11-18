@extends('layouts.app')

@section('title', 'Edit Location - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
            <a href="{{ route('dashboard.locations.index') }}" class="btn btn-outline-secondary btn-sm">
                <span>←</span> Kembali
            </a>
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin: 0;">Edit Lokasi</h1>
            </div>
        </div>
        <p style="color: var(--gray-600); margin-left: 3.5rem;">Perbarui informasi lokasi</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin: 0;">Form Edit Lokasi</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.locations.update', $location) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lokasi *</label>
                            <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $location->name) }}" required placeholder="Contoh: Ruang Operasi Utama">
                            @error('name')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit" class="form-label">Unit *</label>
                            <input type="text" id="unit" name="unit" class="form-input" value="{{ old('unit', $location->unit) }}" required placeholder="Contoh: Instalasi Bedah">
                            @error('unit')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="unit_code" class="form-label">Kode Unit *</label>
                            <input type="text" id="unit_code" name="unit_code" class="form-input" value="{{ old('unit_code', $location->unit_code) }}" required placeholder="Contoh: IB" style="text-transform: uppercase;">
                            @error('unit_code')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                            <small style="color: var(--gray-500); font-size: 0.8rem;">Kode unit akan otomatis dibuat jika belum ada</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="floor" class="form-label">Lantai *</label>
                            <select id="floor" name="floor" class="form-input" required>
                                <option value="">Pilih Lantai</option>
                                <option value="B1" {{ old('floor', $location->floor) == 'LG' ? 'selected' : '' }}>B1 - Lantai Basement</option>
                                <option value="1" {{ old('floor', $location->floor) == '1' ? 'selected' : '' }}>1 - Lantai 1</option>
                                <option value="2" {{ old('floor', $location->floor) == '2' ? 'selected' : '' }}>2 - Lantai 2</option>
                                <option value="3" {{ old('floor', $location->floor) == '3' ? 'selected' : '' }}>3 - Lantai 3</option>
                                <option value="4" {{ old('floor', $location->floor) == '4' ? 'selected' : '' }}>4 - Lantai 4</option>
                                <option value="5" {{ old('floor', $location->floor) == '5' ? 'selected' : '' }}>5 - Lantai 5</option>
                                <option value="6" {{ old('floor', $location->floor) == '6' ? 'selected' : '' }}>6 - Lantai 6</option>
                                <option value="7" {{ old('floor', $location->floor) == '7' ? 'selected' : '' }}>7 - Lantai 7</option>
                                <option value="8" {{ old('floor', $location->floor) == '8' ? 'selected' : '' }}>8 - Lantai 8</option>
                                <option value="9" {{ old('floor', $location->floor) == '9' ? 'selected' : '' }}>9 - Lantai 9</option>
                                <option value="10" {{ old('floor', $location->floor) == '10' ? 'selected' : '' }}>10 - Lantai 10</option>
                            </select>
                            @error('floor')
                                <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200); display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <span>💾</span> Perbarui Lokasi
                    </button>
                    <a href="{{ route('dashboard.locations.index') }}" class="btn btn-outline-secondary">
                        <span>❌</span> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
