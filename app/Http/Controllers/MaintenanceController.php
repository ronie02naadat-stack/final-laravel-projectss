<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display the public maintenance page
     */
    public function show()
    {
        $maintenance = Maintenance::getActive();
        
        if (!$maintenance) {
            return redirect('/');
        }

        return view('maintenance.index', ['maintenance' => $maintenance]);
    }

    /**
     * Display a listing of all maintenance records
     */
    public function index()
    {
        $maintenances = Maintenance::paginate(15);
        return view('maintenance.list', ['maintenances' => $maintenances]);
    }

    /**
     * Show the form for creating a new maintenance record
     */
    public function create()
    {
        return view('maintenance.create');
    }

    /**
     * Store a newly created maintenance record in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'scheduled_start' => 'nullable|date',
            'scheduled_end' => 'nullable|date|after_or_equal:scheduled_start',
            'description' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $validated['status'] = 'scheduled';
        if ($validated['is_active'] ?? false) {
            $validated['status'] = 'ongoing';
        }

        Maintenance::create($validated);

        return redirect()->route('maintenance.index')
                       ->with('success', 'Maintenance record created successfully.');
    }

    /**
     * Activate maintenance mode
     */
    public function activate($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->update([
            'is_active' => true,
            'status' => 'ongoing',
        ]);

        return redirect()->route('maintenance.index')
                       ->with('success', 'Maintenance mode activated.');
    }

    /**
     * Deactivate maintenance mode
     */
    public function deactivate($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->update([
            'is_active' => false,
            'status' => 'completed',
        ]);

        return redirect()->route('maintenance.index')
                       ->with('success', 'Maintenance mode deactivated.');
    }

    /**
     * Delete a maintenance record
     */
    public function destroy($id)
    {
        Maintenance::findOrFail($id)->delete();

        return redirect()->route('maintenance.index')
                       ->with('success', 'Maintenance record deleted successfully.');
    }
}
