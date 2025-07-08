<?php

namespace App\Http\Controllers;
use App\Models\Service;

use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != "customer") {
            $services = Service::all();
        } else {
            $services = Service::where("owner_id", auth()->user()->id)->get();
        }
        return view("services.index", compact('services'));
    }

    public function addPage()
    {
        return view("services.add");
    }

    public function create(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|string',
        ]);

        // Create new service record
        Service::create($validated);

        // Redirect back with success message
        return redirect()->route('services')->with('success', 'Service added successfully.');
    }

    public function detail($id)
    {
        $service = Service::find($id);
        return view("services.detail", compact('service'));
    }

    public function update($id, Request $request)
    {
        $service = Service::find($id);
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|string',
        ]);

        // Create new service record
        $service->update($validated);

        // Redirect back with success message
        return redirect()->route('services')->with('success', 'Service added successfully.');
    }

    public function destroy($id)
    {
        $service = Service::find($id);
        if ($service) {
            $service->delete();
        }
        return redirect()->route('services')->with('success', 'Service deleted successfully');
    }
}
