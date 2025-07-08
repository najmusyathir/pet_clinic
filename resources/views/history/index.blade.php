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
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight"> {{ __('Appointment History') }} </h2>

                <form method="GET" class="flex items-center gap-2">
                    <label for="month" class="text-sm text-gray-600">Filter by Month:</label>
                    <input type="month" id="month" name="month" value="{{ request('month') }}"
                        class="rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <x-primary-button class="!py-1.5 !px-4">Filter</x-primary-button>
                </form>
            </div>

            {{-- Stats Overview --}}
            @if (auth()->user()->role != 'customer')
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


            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full border border-gray-200 divide-y divide-gray-200 shadow-sm rounded-lg py-1">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No.</th>
                                    @if (auth()->user()->role != 'customer')
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Customer</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Pet</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Staff Handled</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Date</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Time</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Bills</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse ($histories as $appointment)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $loop->iteration }}</td>
                                        @if (auth()->user()->role != 'customer')
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->customer->name }}</td>
                                        @endif
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->pet->type }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $appointment->staff_id ? $appointment->staff->name : 'No staff' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $appointment->appointment_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $appointment->appointment_time->format('h:i a') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            RM {{ $appointment->total_price ?? '0.00' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->status }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('history.detail', $appointment->id) }}">
                                                <x-primary-button>Details</x-primary-button>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="p-6 text-center">No Appointment Found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
