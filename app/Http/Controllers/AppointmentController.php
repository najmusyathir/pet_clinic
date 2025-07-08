<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
public function index(Request $request)
{
    $statusFilter = $request->get('status');

    $query = Appointment::query();

    if (auth()->user()->role !== "customer") {
        $query->when($statusFilter, function ($q) use ($statusFilter) {
            return $q->where('status', $statusFilter);
        }, function ($q) {
            return $q->where('status', '!=', 'Completed');
        });
    } else {
        $query->where("customer_id", auth()->user()->id)
            ->when($statusFilter, function ($q) use ($statusFilter) {
                return $q->where('status', $statusFilter);
            }, function ($q) {
                return $q->where('status', '!=', 'Completed');
            });
    }

    $appointments = $query->with(['customer', 'pet', 'staff'])->get();

    return view("appointments.index", compact('appointments', 'statusFilter'));
}



    public function addPage()
    {
        $pets = Pet::where('owner_id', auth()->user()->id)->get();
        $services = Service::all();
        return view("appointments.add", compact("pets", "services"));
    }

    public function create(Request $request)
    {
        // Skip validation for now
        $appointment = Appointment::create([
            'customer_id' => $request->customer_id,
            'pet_id' => $request->pet_id,
            'staff_id' => $request->staff_id ?? null,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'remarks' => $request->remarks,
            'status' => $request->status,
        ]);

        // Attach services if any
        if ($request->has('services')) {
            $appointment->service()->sync($request->services);
        }

        return redirect()->route('appointments')->with('success', 'Appointment added successfully.');
    }


    public function detail($id)
    {
        $appointment = Appointment::with('service')->find($id);
        $pets = Pet::where('owner_id', auth()->user()->id)->get();
        $services = Service::all();
        $staffs = User::where('role', 'staff')->get();

        return view("appointments.detail", compact('appointment', 'pets', 'staffs', 'services'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);

        $basePrice = $request->price ?? 0;
        $selectedServiceIds = $request->input('services', []);

        // Sync services
        $appointment->service()->sync($selectedServiceIds);

        // Calculate total from selected services
        $services = Service::whereIn('id', $selectedServiceIds)->get();
        $serviceTotal = $services->sum('price');
        $totalPrice = $basePrice + $serviceTotal;

        $appointment->update([
            'staff_id' => $request->staff_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'remarks' => $request->remarks,
            'status' => $request->status,
            'diagnosis' => $request->diagnosis,
            'price' => $request->price,
            'total_price' => $totalPrice,
        ]);

        return redirect()->route('appointments')->with('success', 'Appointment updated successfully.');
    }


    public function cancel($id, Request $request)
    {
        $appointment = Appointment::find($id);
        $appointment->update(['status' => 'Cancelled']);

        // Redirect back with success message
        return redirect()->route(route: 'appointments')->with('success', 'Appointment Cancelled.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);
        if ($appointment) {
            $appointment->delete();
        }
        return redirect()->route('appointments')->with('success', 'Appointment deleted successfully');
    }

    public function print($id)
    {
        $appointment = Appointment::with(['customer', 'pet', 'staff', 'service'])->findOrFail($id);

        return view('invoices.index', [
            'appointment' => $appointment
        ]);
    }

}
