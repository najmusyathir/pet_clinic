<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function index()
    {
        if (auth()->user()->role != "customer") {
            $pets = Pet::all();
        } else {
            $pets = Pet::where("owner_id", auth()->user()->id)->get();
        }
        return view("pets.index", compact('pets'));
    }

    public function addPage()
    {
        return view("pets.add");
    }

    public function create(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'owner_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'type' => 'required|string',
            'gender' => 'required|string|in:male,female',
        ]);

        // Create new pet record
        Pet::create($validated);

        // Redirect back with success message
        return redirect()->route('pets')->with('success', 'Pet added successfully.');
    }

    public function detail($id)
    {
        $pet = Pet::find($id);
        $appointments = Appointment::where('pet_id', $id)->get();
        return view("pets.detail", compact('pet', 'appointments'));
    }

    public function update($id, Request $request)
    {
        $pet = Pet::find($id);
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'type' => 'required|string',
            'gender' => 'required|string|in:male,female',
        ]);

        // Create new pet record
        $pet->update($validated);

        // Redirect back with success message
        return redirect()->route('pets')->with('success', 'Pet added successfully.');
    }

    public function destroy($id)
    {
        $pet = Pet::find($id);
        if ($pet) {
            $pet->delete();
        }
        return redirect()->route('pets')->with('success', 'Pet deleted successfully');
    }
}
