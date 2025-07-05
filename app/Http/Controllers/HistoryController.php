<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Pet;
use App\Models\Service;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = auth()->user()->role != "customer" ? Appointment::where('status', 'completed')->get() : Appointment::where("customer_id", auth()->user()->id)->where('status', 'completed')->get();

        return view("history.index", compact('histories'));
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
