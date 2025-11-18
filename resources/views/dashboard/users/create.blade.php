@extends('layouts.app')

@section('title', 'Add New User - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900);">Add New User</h1>
        <p style="color: var(--gray-600);">Create a new application user</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Name *</label>
                    <input type="text" id="name" name="name" class="form-input" value="{{ old('name') }}" required>
                    @error('name')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-input" value="{{ old('email') }}" required>
                    @error('email')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" id="password" name="password" class="form-input" required>
                    @error('password')
                        <div style="color: var(--error); font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required>
                </div>

                <div class="form-group">
                    <label for="is_admin" class="form-label">
                        <input type="checkbox" id="is_admin" name="is_admin" value="1" {{ old('is_admin') ? 'checked' : '' }}>
                        Is Administrator?
                    </label>
                </div>

                <div class="form-group">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin-bottom: 1rem;">Permissions</h3>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
                        <label for="can_view_instrument_sets" class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="can_view_instrument_sets" name="can_view_instrument_sets" value="1" {{ old('can_view_instrument_sets') ? 'checked' : '' }}>
                            Can View Instrument Sets
                        </label>

                        <label for="can_view_qr_codes" class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="can_view_qr_codes" name="can_view_qr_codes" value="1" {{ old('can_view_qr_codes') ? 'checked' : '' }}>
                            Can View QR Codes
                        </label>

                        <label for="can_manage_master_data" class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="can_manage_master_data" name="can_manage_master_data" value="1" {{ old('can_manage_master_data') ? 'checked' : '' }}>
                            Can Manage Master Data
                        </label>

                        <label for="can_view_assets" class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="can_view_assets" name="can_view_assets" value="1" {{ old('can_view_assets') ? 'checked' : '' }}>
                            Can View Assets
                        </label>

                        <label for="can_view_scan_history" class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="can_view_scan_history" name="can_view_scan_history" value="1" {{ old('can_view_scan_history') ? 'checked' : '' }}>
                            Can View Scan History
                        </label>

                        <label for="can_use_scanner" class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                            <input type="checkbox" id="can_use_scanner" name="can_use_scanner" value="1" {{ old('can_use_scanner') ? 'checked' : '' }}>
                            Can Use Scanner
                        </label>
                    </div>
                </div>

                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">Create User</button>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
