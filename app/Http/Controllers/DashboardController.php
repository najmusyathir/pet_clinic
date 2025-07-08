<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'customer') {
            $pets = Pet::where('owner_id', $user->id)->get();
            $appointments = Appointment::where('customer_id', $user->id)
                ->where('appointment_date', '>=', now()->toDateString())
                ->orderBy('appointment_date')
                ->take(5)
                ->get();

            return view('dashboard', compact('pets', 'appointments'));
        }

        // For admin or staff
        $appointments = Appointment::with('service')->get();

        $totalAppointments = $appointments->count();
        $totalRevenue = $appointments->sum('price'); // Treatment price total

        $allServices = Service::all();
        $serviceCounts = [];

        foreach ($allServices as $service) {
            $serviceCounts[$service->name] = [
                'name' => $service->name,
                'count' => 0,
                'revenue' => 0,
            ];
        }

        foreach ($appointments as $appointment) {
            foreach ($appointment->service as $s) {
                $serviceCounts[$s->name]['count']++;
                $serviceCounts[$s->name]['revenue'] += $s->price ?? 0;
            }
        }

        $monthlyStats = Appointment::selectRaw('MONTH(appointment_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartLabels = $monthlyStats->pluck('month')->map(fn($m) => date("F", mktime(0, 0, 0, $m, 10)));
        $chartData = $monthlyStats->pluck('count');

        return view('dashboard', [
            'totalAppointments' => $totalAppointments,
            'totalRevenue' => $totalRevenue,
            'popularService' => collect($serviceCounts)->sortByDesc('count')->first()['name'] ?? '-',
            'serviceStats' => collect($serviceCounts)->sortByDesc('count')->values()->all(),

            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
    }
}
