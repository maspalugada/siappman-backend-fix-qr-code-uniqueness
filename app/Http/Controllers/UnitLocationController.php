<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Location;
use Illuminate\Http\Request;

class UnitLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::with('locations')->orderBy('name')->get();
        $locations = Location::with('unit')->orderBy('name')->get();

        return view('dashboard.unit-locations.index', compact('units', 'locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $units = Unit::orderBy('name')->get();
        return view('dashboard.unit-locations.create', compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:unit,location',
            'unit_name' => 'required_if:type,unit|string|max:255',
            'unit_code' => 'required_if:type,unit|string|max:255',
            'location_name' => 'required_if:type,location|string|max:255',
            'unit_id' => 'required_if:type,location|exists:units,id',
            'floor' => 'nullable|string|max:255',
            'room' => 'nullable|string|max:255',
            'sub_location' => 'nullable|string|max:255',
        ]);

        if ($request->type === 'unit') {
            Unit::create([
                'name' => $request->unit_name,
                'code' => $request->unit_code,
            ]);

            return redirect()->route('dashboard.unit-locations.index')->with('success', 'Unit created successfully.');
        } else {
            Location::create([
                'name' => $request->location_name,
                'unit_id' => $request->unit_id,
                'unit' => Unit::find($request->unit_id)->name,
                'unit_code' => Unit::find($request->unit_id)->code,
                'floor' => $request->floor,
                'room' => $request->room,
                'sub_location' => $request->sub_location,
            ]);

            return redirect()->route('dashboard.unit-locations.index')->with('success', 'Location created successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $units = Unit::orderBy('name')->get();
        $unit = Unit::find($id);
        $location = Location::find($id);

        if ($unit) {
            return view('dashboard.unit-locations.edit', compact('unit', 'units', 'location'));
        } elseif ($location) {
            return view('dashboard.unit-locations.edit', compact('unit', 'units', 'location'));
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::find($id);
        $location = Location::find($id);

        if ($unit) {
            $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|max:255',
            ]);

            $unit->update([
                'name' => $request->name,
                'code' => $request->code,
            ]);

            return redirect()->route('dashboard.unit-locations.index')->with('success', 'Unit updated successfully.');
        } elseif ($location) {
            $request->validate([
                'name' => 'required|string|max:255',
                'unit_id' => 'required|exists:units,id',
                'floor' => 'nullable|string|max:255',
                'room' => 'nullable|string|max:255',
                'sub_location' => 'nullable|string|max:255',
            ]);

            $location->update([
                'name' => $request->name,
                'unit_id' => $request->unit_id,
                'unit' => Unit::find($request->unit_id)->name,
                'unit_code' => Unit::find($request->unit_id)->code,
                'floor' => $request->floor,
                'room' => $request->room,
                'sub_location' => $request->sub_location,
            ]);

            return redirect()->route('dashboard.unit-locations.index')->with('success', 'Location updated successfully.');
        }

        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::find($id);
        $location = Location::find($id);

        if ($unit) {
            $unit->delete();
            return redirect()->route('dashboard.unit-locations.index')->with('success', 'Unit deleted successfully.');
        } elseif ($location) {
            $location->delete();
            return redirect()->route('dashboard.unit-locations.index')->with('success', 'Location deleted successfully.');
        }

        abort(404);
    }
}
