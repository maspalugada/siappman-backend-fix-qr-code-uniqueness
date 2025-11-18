@extends('layouts.app')

@section('title', 'Add Unit or Location - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Add Unit or Location</h1>
        <p style="color: var(--gray-600);">Create a new unit or location</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.unit-locations.store') }}">
                @csrf

                <!-- Type Selection -->
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="type" class="form-label">What do you want to create?</label>
                    <select name="type" id="type" class="form-control" required onchange="toggleForm()">
                        <option value="">Select type...</option>
                        <option value="unit">Unit</option>
                        <option value="location">Location</option>
                    </select>
                </div>

                <!-- Unit Form -->
                <div id="unit-form" style="display: none;">
                    <h4 style="margin-bottom: 1rem;">Unit Details</h4>
                    <div class="form-group">
                        <label for="unit_name" class="form-label">Unit Name</label>
                        <input type="text" name="unit_name" id="unit_name" class="form-control" placeholder="e.g., Operating Room">
                        @error('unit_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="unit_code" class="form-label">Unit Code</label>
                        <input type="text" name="unit_code" id="unit_code" class="form-control" placeholder="e.g., OR">
                        @error('unit_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Location Form -->
                <div id="location-form" style="display: none;">
                    <h4 style="margin-bottom: 1rem;">Location Details</h4>
                    <div class="form-group">
                        <label for="unit_id" class="form-label">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control">
                            <option value="">Select unit...</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }} ({{ $unit->code }})</option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="location_name" class="form-label">Location Name</label>
                        <input type="text" name="location_name" id="location_name" class="form-control" placeholder="e.g., Room 101">
                        @error('location_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="floor" class="form-label">Floor</label>
                        <input type="text" name="floor" id="floor" class="form-control" placeholder="e.g., 1st Floor">
                        @error('floor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="room" class="form-label">Room</label>
                        <input type="text" name="room" id="room" class="form-control" placeholder="e.g., Room 101">
                        @error('room')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sub_location" class="form-label">Sub Location</label>
                        <input type="text" name="sub_location" id="sub_location" class="form-control" placeholder="e.g., Cabinet A">
                        @error('sub_location')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="{{ route('dashboard.unit-locations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleForm() {
    const type = document.getElementById('type').value;
    const unitForm = document.getElementById('unit-form');
    const locationForm = document.getElementById('location-form');

    if (type === 'unit') {
        unitForm.style.display = 'block';
        locationForm.style.display = 'none';
        document.getElementById('unit_name').required = true;
        document.getElementById('unit_code').required = true;
        document.getElementById('location_name').required = false;
        document.getElementById('unit_id').required = false;
    } else if (type === 'location') {
        unitForm.style.display = 'none';
        locationForm.style.display = 'block';
        document.getElementById('unit_name').required = false;
        document.getElementById('unit_code').required = false;
        document.getElementById('location_name').required = true;
        document.getElementById('unit_id').required = true;
    } else {
        unitForm.style.display = 'none';
        locationForm.style.display = 'none';
        document.getElementById('unit_name').required = false;
        document.getElementById('unit_code').required = false;
        document.getElementById('location_name').required = false;
        document.getElementById('unit_id').required = false;
    }
}
</script>
@endsection
