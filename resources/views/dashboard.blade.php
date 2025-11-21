@extends('layouts.app')

@section('title', 'Dashboard - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Dashboard</h1>
        <p style="color: var(--gray-600);">Selamat Datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <div class="dashboard-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <!-- QR Codes Card -->
        @can('can_view_qr_codes')
        <div class="card">
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--card-foreground); margin-bottom: 0.25rem;">QR Codes</h3>
                    <p style="color: var(--muted-foreground); font-size: 0.875rem;">Manage QR codes</p>
                </div>
                <a href="{{ route('dashboard.qr-codes') }}" class="btn btn-secondary" style="width: 100%;">Manage QR Codes</a>
            </div>
        </div>
        @endcan

        <!-- Assets Card -->
        @can('can_view_assets')
        <div class="card">
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--card-foreground); margin-bottom: 0.25rem;">Assets</h3>
                    <p style="color: var(--muted-foreground); font-size: 0.875rem;">Manage instruments & equipment</p>
                </div>
                <a href="{{ route('dashboard.assets.index') }}" class="btn btn-secondary" style="width: 100%;">Manage Assets</a>
            </div>
        </div>
        @endcan

        <!-- Scan History Card -->
        @can('can_view_scan_history')
        <div class="card">
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--card-foreground); margin-bottom: 0.25rem;">Scan History</h3>
                    <p style="color: var(--muted-foreground); font-size: 0.875rem;">View scan activities</p>
                </div>
                <a href="{{ route('dashboard.scan-history') }}" class="btn btn-secondary" style="width: 100%;">View History</a>
            </div>
        </div>
        @endcan

        <!-- Profile Card -->
        <div class="card">
            <div class="card-body">
                <div style="margin-bottom: 1rem;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--card-foreground); margin-bottom: 0.25rem;">Profile</h3>
                    <p style="color: var(--muted-foreground); font-size: 0.875rem;">Manage your account</p>
                </div>
                <a href="{{ route('dashboard.profile') }}" class="btn btn-secondary" style="width: 100%;">Edit Profile</a>
            </div>
        </div>
    </div>

    <!-- My Activity Summary -->
    @if($recentActivities->count() > 0)
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600;">My Activity Summary</h3>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 1.5rem; text-align: center;">
                <p style="font-size: 1rem; color: var(--muted-foreground); margin-bottom: 0.25rem;">Total Scans</p>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--foreground);">{{ $totalScans }}</p>
            </div>

            <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem;">Recent Activities</h4>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 1px solid var(--border);">
                            <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--muted-foreground);">Asset</th>
                            <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--muted-foreground);">Action</th>
                            <th style="padding: 0.75rem 1rem; text-align: left; font-weight: 600; color: var(--muted-foreground);">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActivities as $activity)
                            <tr style="border-bottom: 1px solid var(--border);">
                                <td style="padding: 0.75rem 1rem;">{{ $activity->scannable->name ?? 'N/A' }}</td>
                                <td style="padding: 0.75rem 1rem;">{{ $activity->action }}</td>
                                <td style="padding: 0.75rem 1rem; font-size: 0.875rem; color: var(--muted-foreground);">{{ $activity->scanned_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Quick Actions -->
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600;">Quick Actions</h3>
        </div>
        <div class="card-body">
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('scanner') }}" class="btn btn-primary">
                    Start Scanning
                </a>
                <a href="{{ route('dashboard.assets.create') }}" class="btn btn-secondary">
                    Add New Asset
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media (max-width: 768px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }
</style>
@endpush
@endsection
