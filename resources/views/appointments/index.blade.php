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
            <div class="flex gap-3">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ auth()->user()->role == 'customer' ? __('My ') : '' }}{{ __('Appointments') }}
                </h2>

                @if (auth()->user()->role == 'customer')
                    <a href="{{route('appointment.add')}}">
                        <x-primary-button>Add Appointment</x-primary-button>
                    </a>
                @endif
            </div>
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
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Status</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @if (count($appointments) == 0)
                                    <tr>
                                        <td colspan="6" class="p-6 text-center">No Appointment Found.</td>
                                    </tr>
                                @else
                                    @foreach ($appointments as $index => $appointment)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
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
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->status }}</td>

                                            <td class="px-6 py-4 flex gap-2 flex-wrap">
                                                <a href="{{ route('appointment.detail', $appointment->id) }}">
                                                    <x-primary-button>Details</x-primary-button>
                                                </a>

                                                @if (auth()->user()->role == 'customer')

                                                    <form action="{{ route('appointment.cancel', $appointment->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure to cancel appointment on {{$appointment->appointment_date->format('d M Y')}}?')">
                                                        @csrf
                                                        @method('PUT')
                                                        <x-danger-button class="text-nowrap">Cancel</x-danger-button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
