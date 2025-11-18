@extends('layouts.app')

@section('title', 'Edit Unit - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <nav style="margin-bottom: 1rem;">
            <ol style="list-style: none; padding: 0; margin: 0; display: flex; align-items: center; gap: 0.5rem; font-size: 0.875rem; color: var(--gray-500);">
                <li><a href="{{ route('dashboard') }}" style="color: var(--gray-500); text-decoration: none;">Dashboard</a></li>
                <li style="color: var(--gray-400);">/</li>
                <li><a href="{{ route('dashboard.units.index') }}" style="color: var(--gray-500); text-decoration: none;">Unit</a></li>
                <li style="color: var(--gray-400);">/</li>
                <li style="color: var(--gray-900); font-weight: 500;">Edit</li>
            </ol>
        </nav>
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Edit Unit</h1>
        <p style="color: var(--gray-600);">Perbarui informasi unit "{{ $unit->name }}"</p>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900); margin: 0;">Form Edit Unit</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.units.update', $unit) }}">
                @csrf
                @method('PUT')

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="name" class="form-label">
                            Nama Unit *
                            <span style="color: var(--gray-400); font-weight: 400; font-size: 0.75rem;">(Wajib diisi)</span>
                        </label>
                        <input type="text" id="name" name="name" class="form-input" value="{{ old('name', $unit->name) }}" placeholder="Masukkan nama unit" required>
                        @error('name')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: flex; align-items: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.25rem;">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        <small style="color: var(--gray-500); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                            Contoh: L T 8, SUKAMAN/EBONY, ICU DEWASA
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="code" class="form-label">
                            Kode Unit
                            <span style="color: var(--gray-400); font-weight: 400; font-size: 0.75rem;">(Opsional)</span>
                        </label>
                        <input type="text" id="code" name="code" class="form-input" value="{{ old('code', $unit->code) }}" placeholder="Masukkan kode unit">
                        @error('code')
                            <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem; display: flex; align-items: center;">
                                <svg width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.25rem;">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                        <small style="color: var(--gray-500); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                            Kode singkat untuk identifikasi unit
                        </small>
                    </div>
                </div>

                <div style="margin-top: 1rem; padding: 1rem; background-color: var(--gray-50); border-radius: 0.5rem; border: 1px solid var(--gray-200);">
                    <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--gray-600); font-size: 0.875rem;">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                        <span><strong>Dibuat pada:</strong> {{ $unit->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 0 .5.5h-11a.5.5 0 0 0-.5-.5v-11a.5.5 0 0 0 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                        </svg>
                        Perbarui Unit
                    </button>
                    <a href="{{ route('dashboard.units.index') }}" class="btn btn-secondary">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 0 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
                        </svg>
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background-color: var(--gray-50);
}

.card-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--gray-300);
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(32, 178, 170, 0.1);
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background-color: var(--gray-200);
    color: var(--gray-900);
}

.btn-secondary:hover {
    background-color: var(--gray-300);
    color: var(--gray-900);
    text-decoration: none;
}
</style>
@endsection
