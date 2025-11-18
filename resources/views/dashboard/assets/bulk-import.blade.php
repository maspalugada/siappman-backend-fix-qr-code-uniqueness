@extends('layouts.app')

@section('title', 'Bulk Import Assets - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Import Aset Massal</h1>
        <p style="color: var(--gray-600);">Import banyak aset sekaligus dari file CSV atau Excel</p>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Instructions -->
            <div style="background-color: var(--gray-50); padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">📋 Instruksi Import</h3>
                <ul style="color: var(--gray-700); line-height: 1.6;">
                    <li>Download template CSV untuk format yang benar</li>
                    <li>Pastikan semua kolom wajib diisi (Name, Instrument Type, Unit, Unit Code, Jumlah, Location)</li>
                    <li>Distribusi stok (Steril + Kotor + Proses CSSD) harus sama dengan Jumlah total</li>
                    <li>Specifications dapat dipisahkan dengan koma</li>
                    <li>File maksimal 10MB, format: CSV, XLS, XLSX</li>
                </ul>
            </div>

            <!-- Template Download -->
            <div style="margin-bottom: 2rem;">
                <a href="{{ route('dashboard.assets.download-template') }}" class="btn btn-secondary">
                    📥 Download Template CSV
                </a>
            </div>

            <!-- Import Form -->
            <form method="POST" action="{{ route('dashboard.assets.bulk-import') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="file" class="form-label">Pilih File Import *</label>
                    <input type="file" id="file" name="file" class="form-input" accept=".csv,.xlsx,.xls" required>
                    <small style="color: var(--gray-600);">Format yang didukung: CSV, Excel (.xlsx, .xls)</small>
                    @error('file')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">
                        🚀 Import Aset
                    </button>
                    <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Import Results (if any) -->
    @if(session('import_results'))
        <div class="card" style="margin-top: 2rem;">
            <div class="card-body">
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">
                    📊 Hasil Import
                </h3>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                    <div style="background-color: var(--success-light); color: var(--success); padding: 1rem; border-radius: 0.5rem; text-align: center;">
                        <div style="font-size: 2rem; font-weight: 700;">{{ session('import_results')['success'] }}</div>
                        <div style="font-size: 0.875rem;">Berhasil</div>
                    </div>
                    <div style="background-color: var(--error-light); color: var(--error); padding: 1rem; border-radius: 0.5rem; text-align: center;">
                        <div style="font-size: 2rem; font-weight: 700;">{{ session('import_results')['failed'] }}</div>
                        <div style="font-size: 0.875rem;">Gagal</div>
                    </div>
                </div>

                @if(count(session('import_results')['errors']) > 0)
                    <div style="background-color: var(--error-light); border: 1px solid var(--error); border-radius: 0.5rem; padding: 1rem;">
                        <h4 style="color: var(--error); margin-bottom: 1rem;">❌ Detail Error:</h4>
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 1px solid var(--error);">
                                        <th style="padding: 0.5rem; text-align: left; color: var(--error);">Baris</th>
                                        <th style="padding: 0.5rem; text-align: left; color: var(--error);">Nama</th>
                                        <th style="padding: 0.5rem; text-align: left; color: var(--error);">Error</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('import_results')['errors'] as $error)
                                        <tr style="border-bottom: 1px solid var(--gray-200);">
                                            <td style="padding: 0.5rem;">{{ $error['row'] }}</td>
                                            <td style="padding: 0.5rem;">{{ $error['name'] }}</td>
                                            <td style="padding: 0.5rem; color: var(--error);">{{ $error['error'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');

    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const allowedTypes = ['text/csv', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
            const maxSize = 10 * 1024 * 1024; // 10MB

            if (!allowedTypes.includes(file.type) && !file.name.match(/\.(csv|xlsx|xls)$/i)) {
                alert('Format file tidak didukung. Gunakan CSV atau Excel.');
                this.value = '';
                return;
            }

            if (file.size > maxSize) {
                alert('Ukuran file terlalu besar. Maksimal 10MB.');
                this.value = '';
                return;
            }
        }
    });
});
</script>
@endsection
