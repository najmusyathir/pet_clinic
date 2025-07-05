<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Appointment Receipt</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg text-gray-800 space-y-6 font-sans">
            {{-- Header --}}
            <div class="text-center border-b pb-4">
                <h1 class="text-2xl font-bold text-indigo-700">🧾 Receipt: #A-{{ $appointment->id }}</h1>
                <p class="text-sm text-gray-500">Generated on {{ now()->format('d M Y, h:i A') }}</p>
            </div>

            {{-- Customer & Pet --}}
            <div class="grid grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="text-gray-500">Customer:</p>
                    <p class="font-semibold">{{ $appointment->customer->name }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Pet:</p>
                    <p class="font-semibold">{{ $appointment->pet->name }} ({{ ucfirst($appointment->pet->type) }})</p>
                </div>
                <div>
                    <p class="text-gray-500">Date:</p>
                    <p>{{ $appointment->appointment_date->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Time:</p>
                    <p>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Status:</p>
                    <p
                        class="text-sm font-medium {{ $appointment->status === 'Completed' ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $appointment->status }}
                    </p>
                </div>
                @if($appointment->staff)
                    <div>
                        <p class="text-gray-500">Staff:</p>
                        <p>{{ $appointment->staff->name }}</p>
                    </div>
                @endif
            </div>

            {{-- Remarks --}}
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-500 text-sm mb-1">Remarks:</p>
                <p class="text-sm">{{ $appointment->remarks }}</p>
            </div>

            {{-- Charges --}}
            <div>
                <h2 class="text-lg font-semibold mb-2 border-b pb-2">Charges</h2>
                <table class="w-full text-sm table-auto">
                    <thead>
                        <tr class="border-b text-gray-500 text-left">
                            <th class="py-2">Item</th>
                            <th class="text-right">Amount (RM)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="py-2">Consultation/Treatment Fee</td>
                            <td class="text-right">RM {{ number_format($appointment->price ?? 0, 2) }}</td>
                        </tr>
                        @foreach ($appointment->service as $service)
                            <tr class="border-b">
                                <td class="py-2">{{ $service->name }}</td>
                                <td class="text-right">RM {{ number_format($service->price, 2) }}</td>
                            </tr>
                        @endforeach
                        <tr class="border-t font-semibold">
                            <td class="py-2">Total</td>
                            <td class="text-right text-indigo-700">
                                RM
                                {{ number_format(($appointment->price ?? 0) + $appointment->service->sum('price'), 2) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Print Button --}}
            <div class="flex justify-end pt-4">
                <button onclick="window.print()"
                    class="px-5 py-2 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 print:hidden">
                    🖨️ Print Receipt
                </button>
            </div>
        </div>
    </div>

    {{-- Hide on print --}}
    <style>
        @media print {

            .print\:hidden,
            .the-drawer, .the-navbar {
                display: none !important;
            }
        }
    </style>
</x-app-layout>
