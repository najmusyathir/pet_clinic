<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query()->where('status', 'Completed');

        if (auth()->user()->role === 'customer') {
            $query->where('customer_id', auth()->id());
        }

        if ($request->filled('month')) {
            try {
                [$year, $month] = explode('-', $request->month);
                $query->whereYear('appointment_date', $year)
                    ->whereMonth('appointment_date', $month);
            } catch (\Exception $e) {
            }
        }

        $histories = $query->with(['customer', 'staff', 'pet'])->orderBy('appointment_date', 'desc')->get();

        return view('history.index', compact('histories'));
    }




    public function detail($id)
    {
        $appointment = Appointment::with('service')->find($id);
        $pets = Pet::where('owner_id', auth()->user()->id)->get();
        $services = Service::all();
        $staffs = User::where('role', 'staff')->get();

        return view("history.detail", compact('appointment', 'pets', 'staffs', 'services'));
    }


}
