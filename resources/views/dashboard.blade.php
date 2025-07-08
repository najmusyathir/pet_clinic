<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if (auth()->user()->role != 'customer')
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                {{-- Stats Overview --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="text-gray-600 text-sm">Total Appointments</h3>
                        <p class="text-2xl font-bold">{{ $totalAppointments }}</p>
                    </div>
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="text-gray-600 text-sm">Total Revenue</h3>
                        <p class="text-xs text-gray-500 mb-1">Includes treatment fees + services</p>
                        <p class="text-2xl font-bold">RM {{ number_format($totalRevenue, 2) }}</p>
                    </div>
                    <div class="bg-white shadow rounded-lg p-4">
                        <h3 class="text-gray-600 text-sm">Most Popular Service</h3>
                        <p class="text-2xl font-bold">{{ $popularService }}</p>
                    </div>
                </div>

                {{-- Chart Section --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Appointments per Month</h3>
                    <canvas id="appointmentChart"></canvas>
                </div>

                {{-- Service Usage Grid --}}
                @if (!empty($serviceStats))
                    <div class="bg-white p-6 shadow rounded-lg">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Service Usage Summary</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4">
                            @foreach ($serviceStats as $service)
                                <div class="bg-indigo-50 rounded-lg p-4 shadow text-center">
                                    <p class="text-sm text-gray-600 font-medium">{{ $service['name'] }}</p>
                                    <p class="text-xl font-bold text-indigo-700">{{ $service['count'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Services Table --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium mb-4">Service Revenue Breakdown</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Service</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Used Count</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-500">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($serviceStats as $service)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $service['name'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $service['count'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">RM {{ number_format($service['revenue'], 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- Chart Script --}}
            @if (auth()->user()->role != 'customer')
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    const ctx = document.getElementById('appointmentChart').getContext('2d');
                    const appointmentChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [{
                                label: 'Appointments',
                                data: @json($chartData),
                                borderColor: 'rgba(75, 192, 192, 1)',
                                tension: 0.4,
                                fill: false,
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: { beginAtZero: true }
                            }
                        }
                    });
                </script>
            @endif


        @else


            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                {{-- Welcome Section --}}
                <div class="bg-gradient-to-r from-purple-100 to-indigo-100 p-8 rounded-2xl shadow-md text-center">
                    <h2 class="text-3xl font-bold text-indigo-800 mb-2">Welcome back, {{ auth()->user()->name }} 🐶</h2>
                    <p class="text-sm text-indigo-700">Here’s a quick glance at your pet’s world today.</p>
                </div>

                {{-- Info Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- My Pets --}}
                    <div class="bg-white/60 backdrop-blur rounded-2xl shadow-md p-6 border border-white/40">
                        <h3 class="text-xl font-semibold text-[#3b2f63] mb-4">🐾 Your Pets</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse ($pets as $pet)
                                <li class="py-2">
                                    <span class="font-semibold">{{ $pet->name }}</span> —
                                    {{ ucfirst($pet->type) }}, {{ ucfirst($pet->gender) }}
                                    (Born: {{ $pet->birth_date->format('M d, Y') }})
                                </li>
                            @empty
                                <li class="py-2 text-gray-500">No pets registered yet.</li>
                            @endforelse
                        </ul>
                    </div>

                    {{-- Upcoming Appointments --}}
                    <div class="bg-white/60 backdrop-blur rounded-2xl shadow-md p-6 border border-white/40">
                        <h3 class="text-xl font-semibold text-[#3b2f63] mb-4">📅 Upcoming Appointments</h3>
                        <ul class="divide-y divide-gray-200">
                            @forelse ($appointments as $appointment)
                                <li class="py-2">
                                    {{ $appointment->appointment_date->format('d M Y') }} at
                                    {{ $appointment->appointment_time->format('H:i') }} —
                                    with {{ optional($appointment->staff)->name ?? 'Unassigned' }}
                                </li>
                            @empty
                                <li class="py-2 text-gray-500">No upcoming appointments.</li>
                            @endforelse
                        </ul>
                    </div>

                </div>

                {{-- Promo Section --}}
                <div
                    class="bg-gradient-to-r from-pink-100 to-yellow-100 p-8 rounded-2xl shadow-md text-center border border-pink-200/40">
                    <h3 class="text-2xl font-bold text-pink-700 mb-2">🧼 Grooming Promo!</h3>
                    <p class="text-sm text-pink-600 mb-4">Enjoy 20% off all grooming services this month. Treat your pet
                        today!</p>
                    <a href="{{ route('appointment.create') }}"
                        class="inline-block px-6 py-3 rounded-xl bg-pink-600 text-white font-semibold hover:bg-pink-700 transition">
                        Book Appointment
                    </a>
                </div>

            </div>


        @endif
    </div>

    {{-- Chart.js CDN and Script --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (auth()->user()->role != 'customer')
        <script>
            const ctx = document.getElementById('appointmentChart').getContext('2d');
            const appointmentChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Appointments',
                        data: @json($chartData),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        tension: 0.4,
                        fill: false,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script>
    @endif
</x-app-layout>
