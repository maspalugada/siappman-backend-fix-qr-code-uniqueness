@extends('layouts.app')

@section('title', 'Edit Unit or Location - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">
            @if($unit)
                Edit Unit: {{ $unit->name }}
            @elseif($location)
                Edit Location: {{ $location->name }}
            @endif
        </h1>
        <p style="color: var(--gray-600);">Update unit or location details</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('dashboard.unit-locations.update', $unit ? $unit->id : $location->id) }}">
                @csrf
                @method('PUT')

                @if($unit)
                    <!-- Unit Edit Form -->
                    <h4 style="margin-bottom: 1rem;">Unit Details</h4>
                    <div class="form-group">
                        <label for="name" class="form-label">Unit Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $unit->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="code" class="form-label">Unit Code</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $unit->code) }}" required>
                        @error('code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @elseif($location)
                    <!-- Location Edit Form -->
                    <h4 style="margin-bottom: 1rem;">Location Details</h4>
                    <div class="form-group">
                        <label for="unit_id" class="form-label">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control" required>
                            <option value="">Select unit...</option>
                            @foreach($units as $unitOption)
                                <option value="{{ $unitOption->id }}" {{ old('unit_id', $location->unit_id) == $unitOption->id ? 'selected' : '' }}>
                                    {{ $unitOption->name }} ({{ $unitOption->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">Location Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $location->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="floor" class="form-label">Floor</label>
                        <input type="text" name="floor" id="floor" class="form-control" value="{{ old('floor', $location->floor) }}">
                        @error('floor')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="room" class="form-label">Room</label>
                        <input type="text" name="room" id="room" class="form-control" value="{{ old('room', $location->room) }}">
                        @error('room')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="sub_location" class="form-label">Sub Location</label>
                        <input type="text" name="sub_location" id="sub_location" class="form-control" value="{{ old('sub_location', $location->sub_location) }}">
                        @error('sub_location')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                @endif

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('dashboard.unit-locations.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
