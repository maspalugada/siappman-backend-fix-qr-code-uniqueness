@extends('layouts.app')

@section('title', 'Unit & Location Management - SiAPPMan')

@section('content')
<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">Unit & Location Management</h1>
        <p style="color: var(--gray-600);">Manage units and their associated locations in one place</p>
    </div>

    <div style="margin-bottom: 2rem;">
        <a href="{{ route('dashboard.unit-locations.create') }}" class="btn btn-primary">
            <span style="margin-right: 0.5rem;">+</span>
            Add Unit or Location
        </a>
    </div>

    <!-- Units Section -->
    <div class="card" style="margin-bottom: 2rem;">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Units</h3>
        </div>
        <div class="card-body">
            @if($units->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Locations Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($units as $unit)
                                <tr>
                                    <td>{{ $unit->name }}</td>
                                    <td><code>{{ $unit->code }}</code></td>
                                    <td>{{ $unit->locations->count() }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.unit-locations.edit', $unit->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('dashboard.unit-locations.destroy', $unit->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No units found. <a href="{{ route('dashboard.unit-locations.create') }}">Create one</a></p>
            @endif
        </div>
    </div>

    <!-- Locations Section -->
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.25rem; font-weight: 600; color: var(--gray-900);">Locations</h3>
        </div>
        <div class="card-body">
            @if($locations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Unit</th>
                                <th>Floor</th>
                                <th>Room</th>
                                <th>Sub Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr>
                                    <td>{{ $location->name }}</td>
                                    <td>{{ $location->unit }} <small class="text-muted">({{ $location->unit_code }})</small></td>
                                    <td>{{ $location->floor ?: '-' }}</td>
                                    <td>{{ $location->room ?: '-' }}</td>
                                    <td>{{ $location->sub_location ?: '-' }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.unit-locations.edit', $location->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('dashboard.unit-locations.destroy', $location->id) }}" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">No locations found. <a href="{{ route('dashboard.unit-locations.create') }}">Create one</a></p>
            @endif
        </div>
    </div>
</div>
@endsection
