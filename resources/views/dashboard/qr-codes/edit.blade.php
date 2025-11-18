@extends('layouts.app')

@section('title', 'Edit Kode QR - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Edit Kode QR</h1>
        <p style="color: var(--gray-600);">Perbarui informasi kode QR</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Form Edit Kode QR</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.qr-codes.update', $qrCode) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="label" class="form-label">Label</label>
                    <input type="text" id="label" name="label" class="form-control" value="{{ old('label', $qrCode->label) }}" required>
                    @error('label')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location" class="form-label">Lokasi</label>
                    <input type="text" id="location" name="location" class="form-control" value="{{ old('location', $qrCode->location) }}">
                    @error('location')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="form-label">Tipe</label>
                    <select id="type" name="type" class="form-control" required>
                        <option value="text" {{ old('type', $qrCode->type ?? 'text') == 'text' ? 'selected' : '' }}>Teks</option>
                        <option value="url" {{ old('type', $qrCode->type ?? 'url') == 'url' ? 'selected' : '' }}>URL</option>
                        <option value="phone" {{ old('type', $qrCode->type ?? 'phone') == 'phone' ? 'selected' : '' }}>Telepon</option>
                        <option value="email" {{ old('type', $qrCode->type ?? 'email') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                    @error('type')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content" class="form-label">Konten</label>
                    <textarea id="content" name="content" class="form-control" rows="4" required>{{ old('content', $qrCode->content) }}</textarea>
                    @error('content')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('dashboard.qr-codes.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui Kode QR</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
