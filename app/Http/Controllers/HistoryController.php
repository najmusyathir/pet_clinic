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
                // Invalid format fallback
            }
        }

        $histories = $query->with(['customer', 'staff', 'pet', 'service'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        $totalAppointments = $histories->count();
        $totalRevenue = $histories->sum('price');
        $allServices = Service::all();
        $serviceCounts = [];

        foreach ($allServices as $service) {
            $serviceCounts[$service->name] = [
                'name' => $service->name,
                'count' => 0,
                'revenue' => 0,
            ];
        }

        foreach ($histories as $appointment) {
            foreach ($appointment->service as $s) {
                $serviceCounts[$s->name]['count']++;
                $serviceCounts[$s->name]['revenue'] += $s->price ?? 0;
            }
        }

        $monthlyStats = $query->selectRaw('MONTH(appointment_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $chartLabels = $monthlyStats->pluck('month')->map(fn($m) => date("F", mktime(0, 0, 0, $m, 10)));
        $chartData = $monthlyStats->pluck('count');

        return view('history.index', [
            'histories' => $histories,
            'totalAppointments' => $totalAppointments,
            'totalRevenue' => $totalRevenue,
            'popularService' => collect($serviceCounts)->sortByDesc('count')->first()['name'] ?? '-',
            'serviceStats' => collect($serviceCounts)->sortByDesc('count')->values()->all(),

            'chartLabels' => $chartLabels,
            'chartData' => $chartData,
        ]);
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
