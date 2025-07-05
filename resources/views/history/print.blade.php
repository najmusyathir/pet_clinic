<x-app-layout>
    <x-slot name="header">
        @if (session('success'))
            <div class="bg-green-100 border text-sm border-green-600 text-green-700 rounded px-6 py-3">
                {{ session('success') }}
            </div>
        @endif
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">{{ __('Appointment History') }}</h2>

                <form method="GET" class="flex items-center gap-2">
                    <input type="month" name="month" value="{{ request('month') }}"
                        class="rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <x-primary-button class="!py-1.5 !px-4">Filter</x-primary-button>
                </form>
            </div>

            <div class="flex justify-end">
                <button onclick="window.print()"
                    class="mt-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 print:hidden">
                    🖨️ Print History
                </button>
            </div>

            <div id="printable-area" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">
                {{-- Chart --}}
                <div>
                    <h3 class="text-lg font-semibold mb-4">📈 Appointments This Month</h3>
                    <canvas id="appointmentsChart" height="100"></canvas>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200 shadow-sm rounded-lg">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No.</th>
                                @if (auth()->user()->role != 'customer')
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Customer</th>
                                @endif
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Pet</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Staff</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Time</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Total (RM)</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($histories as $appointment)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                    @if (auth()->user()->role != 'customer')
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->customer->name }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->pet->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->staff->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->appointment_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->appointment_time->format('h:i A') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">RM {{ number_format($appointment->total_price ?? 0, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->status }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-6 text-center text-sm text-gray-500">No data found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('appointmentsChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Appointments per Day',
                    backgroundColor: '#6366f1',
                    data: {!! json_encode($chartCounts) !!}
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

    <style>
        @media print {
            .print\:hidden {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
