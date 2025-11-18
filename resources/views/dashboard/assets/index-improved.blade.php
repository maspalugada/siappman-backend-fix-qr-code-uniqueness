@extends('layouts.app')

@section('title', 'Assets List - SiAPPMan')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Manajemen Aset</h1>
        <p style="color: var(--gray-600);">Kelola instrumen dan peralatan Anda</p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('dashboard.assets.bulk-import.form') }}" class="btn btn-secondary">
                📤 Import Massal
            </a>
            <a href="{{ route('dashboard.assets.export', ['format' => 'csv']) }}" class="btn btn-secondary">
                📥 Export CSV
            </a>
            <a href="{{ route('dashboard.assets.create') }}" class="btn btn-primary">
                <span style="margin-right: 0.5rem;">+</span>
                Tambah Aset Baru
            </a>
        </div>
    </div>

    <!-- Advanced Search & Filters -->
    <div style="margin-bottom: 2rem;">
        <form action="{{ route('dashboard.assets.index') }}" method="GET" id="filterForm">
            <!-- Search Input -->
            <div style="margin-bottom: 1rem;">
                <input type="text" name="search" placeholder="Cari berdasarkan nama, tipe, QR code, atau unit..." value="{{ request('search') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
            </div>

            <!-- Filter Row -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                <!-- Status Filter -->
                <select name="status" style="padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
                    <option value="">Semua Status</option>
                    <option value="Ready" {{ request('status') === 'Ready' ? 'selected' : '' }}>Ready</option>
                    <option value="Washing" {{ request('status') === 'Washing' ? 'selected' : '' }}>Washing</option>
                    <option value="Sterilizing" {{ request('status') === 'Sterilizing' ? 'selected' : '' }}>Sterilizing</option>
                    <option value="In Use" {{ request('status') === 'In Use' ? 'selected' : '' }}>In Use</option>
                    <option value="Maintenance" {{ request('status') === 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="In Transit" {{ request('status') === 'In Transit' ? 'selected' : '' }}>In Transit</option>
                    <option value="In Process" {{ request('status') === 'In Process' ? 'selected' : '' }}>In Process</option>
                    <option value="Returning" {{ request('status') === 'Returning' ? 'selected' : '' }}>Returning</option>
                    <option value="Returned" {{ request('status') === 'Returned' ? 'selected' : '' }}>Returned</option>
                </select>

                <!-- Location Filter -->
                <select name="location" style="padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
                    <option value="">Semua Lokasi</option>
                    @foreach(\App\Models\Location::all() as $location)
                        <option value="{{ $location->name }}" {{ request('location') === $location->name ? 'selected' : '' }}>{{ $location->name }}</option>
                    @endforeach
                </select>

                <!-- Unit Filter -->
                <select name="unit" style="padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
                    <option value="">Semua Unit</option>
                    @foreach(\App\Models\Unit::all() as $unit)
                        <option value="{{ $unit->name }}" {{ request('unit') === $unit->name ? 'selected' : '' }}>{{ $unit->name }}</option>
                    @endforeach
                </select>

                <!-- Instrument Type Filter -->
                <select name="instrument_type" style="padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
                    <option value="">Semua Tipe Instrumen</option>
                    @foreach(\App\Models\InstrumentType::all() as $type)
                        <option value="{{ $type->name }}" {{ request('instrument_type') === $type->name ? 'selected' : '' }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: var(--gray-700); margin-bottom: 0.25rem;">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--gray-300); border-radius: 0.5rem;">
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">🔍 Filter & Cari</button>
                <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary">🔄 Reset Filter</a>
                <button type="button" onclick="toggleAdvancedFilters()" class="btn btn-secondary" id="toggleFiltersBtn">📊 Sembunyikan Filter</button>
            </div>
        </form>
    </div>

    @if($assets->count() > 0)
        <div class="card">
            <div class="card-body">
                <!-- Mobile View Toggle -->
                <div style="margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 0.875rem; color: var(--gray-600);">
                        Menampilkan {{ $assets->count() }} dari {{ $assets->total() }} aset
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button id="tableViewBtn" class="btn btn-sm btn-secondary active" onclick="toggleView('table')">📊 Tabel</button>
                        <button id="cardViewBtn" class="btn btn-sm btn-secondary" onclick="toggleView('card')">📱 Kartu</button>
                    </div>
                </div>

                <!-- Table View -->
                <div id="tableView" class="table-container">
                    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 1200px;">
                            <thead>
                                <tr style="border-bottom: 1px solid var(--gray-200);">
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 200px; cursor: pointer;" onclick="sortBy('name')">
                                        Nama & QR
                                        @if(request('sort_by') === 'name')
                                            {{ request('sort_direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 120px; cursor: pointer;" onclick="sortBy('instrument_type')">
                                        Tipe
                                        @if(request('sort_by') === 'instrument_type')
                                            {{ request('sort_direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 150px; cursor: pointer;" onclick="sortBy('unit')">
                                        Unit
                                        @if(request('sort_by') === 'unit')
                                            {{ request('sort_direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 100px;">Stok</th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 120px; cursor: pointer;" onclick="sortBy('location')">
                                        Lokasi
                                        @if(request('sort_by') === 'location')
                                            {{ request('sort_direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 120px; cursor: pointer;" onclick="sortBy('status')">
                                        Status
                                        @if(request('sort_by') === 'status')
                                            {{ request('sort_direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 150px; cursor: pointer;" onclick="sortBy('created_at')">
                                        Dibuat
                                        @if(request('sort_by') === 'created_at')
                                            {{ request('sort_direction') === 'asc' ? '↑' : '↓' }}
                                        @endif
                                    </th>
                                    <th style="padding: 1rem; text-align: left; font-weight: 600; color: var(--gray-900); min-width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assets as $asset)
                                    <tr style="border-bottom: 1px solid var(--gray-100);">
                                        <td style="padding: 1rem;">
                                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                <div>
                                                    <div style="font-weight: 500; color: var(--gray-900); margin-bottom: 0.25rem;">{{ $asset->name }}</div>
                                                    <div style="font-size: 0.75rem; color: var(--gray-500); font-family: monospace;">{{ $asset->qr_code }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->instrument_type }}</td>
                                        <td style="padding: 1rem;">
                                            <div style="color: var(--gray-600); font-size: 0.875rem;">
                                                <div>{{ $asset->unit }}</div>
                                                <div style="color: var(--gray-400); font-size: 0.75rem;">{{ $asset->unit_code }}</div>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                                <div style="font-size: 0.875rem; font-weight: 500; color: var(--gray-900);">Total: {{ $asset->jumlah }}</div>
                                                <div style="display: flex; gap: 0.5rem; font-size: 0.75rem;">
                                                    <span style="color: #10B981;">● {{ $asset->jumlah_steril ?? 0 }} Steril</span>
                                                    <span style="color: #F59E0B;">● {{ $asset->jumlah_kotor ?? 0 }} Kotor</span>
                                                    <span style="color: #6B7280;">● {{ $asset->jumlah_proses_cssd ?? 0 }} Proses</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="padding: 1rem; color: var(--gray-600);">{{ $asset->location }}</td>
                                        <td style="padding: 1rem;">
                                            @php
                                                $statusConfig = [
                                                    'Ready' => ['icon' => '✅', 'color' => '#D1FAE5', 'textColor' => '#065F46'],
                                                    'Washing' => ['icon' => '🧼', 'color' => '#DBEAFE', 'textColor' => '#1E40AF'],
                                                    'Sterilizing' => ['icon' => '🔥', 'color' => '#DBEAFE', 'textColor' => '#1E40AF'],
                                                    'In Use' => ['icon' => '🔄', 'color' => '#E5E7EB', 'textColor' => '#374151'],
                                                    'Maintenance' => ['icon' => '🔧', 'color' => '#FEF3C7', 'textColor' => '#92400E'],
                                                    'In Transit' => ['icon' => '🚚', 'color' => '#F3E8FF', 'textColor' => '#6B21A8'],
                                                    'In Transit (Sterile)' => ['icon' => '🚚', 'color' => '#F3E8FF', 'textColor' => '#6B21A8'],
                                                    'In Transit (Dirty)' => ['icon' => '🚚', 'color' => '#F3E8FF', 'textColor' => '#6B21A8'],
                                                    'In Process' => ['icon' => '⚙️', 'color' => '#FED7D7', 'textColor' => '#C53030'],
                                                    'Returning' => ['icon' => '↩️', 'color' => '#C6F6D5', 'textColor' => '#22543D'],
                                                    'Returned' => ['icon' => '✅', 'color' => '#C6F6D5', 'textColor' => '#22543D'],
                                                ];
                                                $config = $statusConfig[$asset->status] ?? ['icon' => '❓', 'color' => '#F7FAFC', 'textColor' => '#2D3748'];
                                            @endphp
                                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: {{ $config['color'] }}; color: {{ $config['textColor'] }}; display: inline-flex; align-items: center; gap: 0.25rem;">
                                                <span>{{ $config['icon'] }}</span>
                                                {{ $asset->status }}
                                            </span>
                                        </td>
                                        <td style="padding: 1rem;">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" onclick="toggleDropdown({{ $asset->id }})">
                                                    Aksi ▼
                                                </button>
                                                <div id="dropdown-{{ $asset->id }}" class="dropdown-menu" style="display: none;">
                                                    <a href="{{ route('dashboard.assets.show', $asset) }}" class="dropdown-item">👁️ Lihat Detail</a>
                                                    <a href="{{ route('dashboard.assets.edit', $asset) }}" class="dropdown-item">✏️ Edit Aset</a>
                                                    <button onclick="showQRModal({{ $asset->id }}, '{{ $asset->name }}', '{{ $asset->instrument_type }}', '{{ $asset->location }}', '{{ $asset->qr_code }}')" class="dropdown-item">📱 QR Code</button>
                                                    <div class="dropdown-divider"></div>
                                                    <form method="POST" action="{{ route('dashboard.assets.destroy', $asset) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" style="border: none; background: none; width: 100%; text-align: left;">🗑️ Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card View for Mobile -->
                <div id="cardView" class="card-container" style="display: none;">
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 1rem;">
                        @foreach($assets as $asset)
                            <div class="asset-card" style="border: 1px solid var(--gray-200); border-radius: 0.75rem; padding: 1.5rem; background: white;">
                                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                    <div style="flex: 1;">
                                        <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">{{ $asset->name }}</h3>
                                        <p style="font-size: 0.875rem; color: var(--gray-500); font-family: monospace; margin-bottom: 0.5rem;">{{ $asset->qr_code }}</p>
                                        <p style="font-size: 0.875rem; color: var(--gray-600);">{{ $asset->instrument_type }}</p>
                                    </div>
                                    @php
                                        $config = $statusConfig[$asset->status] ?? ['icon' => '❓', 'color' => '#F7FAFC', 'textColor' => '#2D3748'];
                                    @endphp
                                    <span style="padding: 0.25rem 0.5rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 500; background-color: {{ $config['color'] }}; color: {{ $config['textColor'] }}; display: inline-flex; align-items: center; gap: 0.25rem;">
                                        <span>{{ $config['icon'] }}</span>
                                        {{ $asset->status }}
                                    </span>
                                </div>

                                <div style="margin-bottom: 1rem;">
                                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">
                                        <strong>{{ $asset->unit }}</strong> ({{ $asset->unit_code }})
                                    </div>
                                    <div style="font-size: 0.875rem; color: var(--gray-600);">
                                        📍 {{ $asset->location }}
                                    </div>
                                </div>

                                <div style="margin-bottom: 1rem;">
                                    <div style="font-size: 0.875rem; font-weight: 500; color: var(--gray-900); margin-bottom: 0.5rem;">Stok: {{ $asset->jumlah }} total</div>
                                    <div style="display: flex; gap: 0.75rem; font-size: 0.75rem;">
                                        <span style="color: #10B981;">● {{ $asset->jumlah_steril ?? 0 }} Steril</span>
                                        <span style="color: #F59E0B;">● {{ $asset->jumlah_kotor ?? 0 }} Kotor</span>
                                        <span style="color: #6B7280;">● {{ $asset->jumlah_proses_cssd ?? 0 }} Proses</span>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                                    <a href="{{ route('dashboard.assets.show', $asset) }}" class="btn btn-sm btn-secondary">👁️ Lihat</a>
                                    <a href="{{ route('dashboard.assets.edit', $asset) }}" class="btn btn-sm btn-secondary">✏️ Edit</a>
                                    <button onclick="showQRModal({{ $asset->id }}, '{{ $asset->name }}', '{{ $asset->instrument_type }}', '{{ $asset->location }}', '{{ $asset->qr_code }}')" class="btn btn-sm btn-secondary">📱 QR</button>
                                    <form method="POST" action="{{ route('dashboard.assets.destroy', $asset) }}" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm" style="background-color: #EF4444; color: white; border: none; border-radius: 0.375rem;">🗑️ Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
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

    // Toggle advanced filters
    let filtersVisible = true;
    window.toggleAdvancedFilters = function() {
        const filterForm = document.getElementById('filterForm');
        const toggleBtn = document.getElementById('toggleFiltersBtn');

        if (filtersVisible) {
            // Hide filters (show only search input)
            const searchInput = filterForm.querySelector('input[name="search"]').parentElement;
            const allElements = filterForm.querySelectorAll('div');
            allElements.forEach(el => {
                if (!el.contains(searchInput)) {
                    el.style.display = 'none';
                }
            });
            toggleBtn.textContent = '📊 Tampilkan Filter';
        } else {
            // Show all filters
            const allElements = filterForm.querySelectorAll('div');
            allElements.forEach(el => {
                el.style.display = '';
            });
            toggleBtn.textContent = '📊 Sembunyikan Filter';
        }
        filtersVisible = !filtersVisible;
    };

    // Sorting functionality
    window.sortBy = function(field) {
        const currentSort = '{{ request("sort_by") }}';
        const currentDirection = '{{ request("sort_direction") }}';

        let newDirection = 'asc';
        if (currentSort === field && currentDirection === 'asc') {
            newDirection = 'desc';
        }

        // Build URL with current query parameters plus sort
        const url = new URL(window.location);
        url.searchParams.set('sort_by', field);
        url.searchParams.set('sort_direction', newDirection);

        window.location.href = url.toString();
    };
});

// View toggle functionality
function toggleView(viewType) {
    const tableView = document.getElementById('tableView');
    const cardView = document.getElementById('cardView');
    const tableBtn = document.getElementById('tableViewBtn');
    const cardBtn = document.getElementById('cardViewBtn');

    if (viewType === 'table') {
        tableView.style.display = 'block';
        cardView.style.display = 'none';
        tableBtn.classList.add('active');
        cardBtn.classList.remove('active');
        localStorage.setItem('assetView', 'table');
    } else {
        tableView.style.display = 'none';
        cardView.style.display = 'block';
        tableBtn.classList.remove('active');
        cardBtn.classList.add('active');
        localStorage.setItem('assetView', 'card');
    }
}

// Load saved view preference
const savedView = localStorage.getItem('assetView');
if (savedView === 'card') {
    toggleView('card');
}

// Dropdown functionality
function toggleDropdown(assetId) {
    const dropdown = document.getElementById(`dropdown-${assetId}`);
    const isVisible = dropdown.style.display === 'block';

    // Close all dropdowns first
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
    });

    // Toggle current dropdown
    if (!isVisible) {
        dropdown.style.display = 'block';
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown')) {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    }
});
</script>
<script>
let currentQRCanvas = null;

function showQRModal(id, name, type, location, qrCode) {
    // Close any open dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.style.display = 'none';
    });

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
.table-container {
    position: relative;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-toggle {
    cursor: pointer;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    min-width: 160px;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 0.875rem;
    color: var(--gray-900);
    background-color: white;
    border: 1px solid var(--gray-200);
    border-radius: 0.375rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: normal;
    color: var(--gray-900);
    text-align: inherit;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
    text-decoration: none;
}

.dropdown-item:hover {
    color: var(--gray-900);
    background-color: var(--gray-100);
}

.dropdown-divider {
    height: 0;
    margin: 0.5rem 0;
    overflow: hidden;
    border-top: 1px solid var(--gray-200);
}

.text-danger {
    color: #EF4444 !important;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.75rem;
    border-radius: 0.25rem;
}

.btn.active {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

/* Mobile responsive */
@media (max-width: 768px) {
    .table-container {
        display: none;
    }

    .card-container {
        display: block !important;
    }

    #tableViewBtn, #cardViewBtn {
        display: none;
    }

    .asset-card {
        margin-bottom: 1rem;
    }
}

.modal-content {
    animation: modalopen 0.3s;
}

@keyframes modalopen {
    from {opacity: 0; transform: translateY(-50px);}
    to {opacity: 1; transform: translateY(0);}
}
</style>
@endsection
