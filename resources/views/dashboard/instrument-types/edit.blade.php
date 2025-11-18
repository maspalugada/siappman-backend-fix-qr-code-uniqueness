@extends('layouts.app')

@section('title', 'Edit Tipe Instrumen - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Edit Tipe Instrumen</h1>
        <p style="color: var(--gray-600);">Perbarui informasi tipe instrumen</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Form Edit Tipe Instrumen</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.instrument-types.update', $instrumentType) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name" class="form-label">Nama Tipe Instrumen</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $instrumentType->name) }}" required>
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-control" rows="3">{{ old('description', $instrumentType->description) }}</textarea>
                    @error('description')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('dashboard.instrument-types.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Perbarui Tipe Instrumen</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
