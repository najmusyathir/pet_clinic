<x-app-layout>
    <x-slot name="header"> </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Edit Appointment') }}
            </h2>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 max-w-4xl">
                    <form class="grid grid-cols-2 gap-6">

                        <!-- Customer -->
                        <div>
                            <x-input-label for="Customer" :value="__('Customer Name')" />
                            <input type="hidden" name="customer_id" value="{{ $appointment->customer_id }}" />
                            <x-text-input class="block mt-1 w-full text-gray-400" type="text" disabled
                                value="{{ $appointment->customer->name }}" />
                        </div>

                        <!-- Pet -->
                        <div>
                            <x-input-label for="Pet" :value="__('Pet')" />
                            <x-text-input class="block mt-1 w-full text-gray-400" type="text" disabled
                                value="{{ $appointment->pet->name }}" />
                        </div>

                        <!-- Staff -->
                        <div class="flex-1 flex flex-col">
                            <x-input-label for="staff_id" :value="__('Staff')" />
                            <select name='staff_id' id='staff_id'
                                class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                disabled>
                                <option value=''> No Staff </option>
                                @if (count($staffs) != 0)
                                    @foreach ($staffs as $staff)
                                        <option value='{{$staff->id}}' {{ $appointment->staff_id == $staff->id ? 'selected' : '' }}> {{$staff->name}} </option>
                                    @endforeach
                                @endif

                            </select>
                        </div>

                        <!-- Appointment Date -->
                        <div>
                            <x-input-label for="appointment_date" :value="__('Appointment Date')" />
                            <x-text-input id="appointment_date" class="block mt-1 w-full text-slate-400" type="date"
                                name="appointment_date" value="{{ $appointment->appointment_date->format('Y-m-d') }}"
                                disabled />
                        </div>

                        <!-- Appointment Time -->
                        <div>
                            <x-input-label for="appointment_time" :value="__('Appointment Time')" />
                            <x-text-input id="appointment_time" class="block mt-1 w-full text-slate-400" type="time"
                                name="appointment_time"
                                value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}"
                                step="1800" min="08:00" max="20:00" required disabled />
                        </div>

                        <!-- Remarks -->
                        <div class="col-span-2">
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <textarea rows="3" id="remarks"
                                class="block mt-1 w-full rounded-lg text-gray-400 p-2 border border-gray-300"
                                name="remarks" disabled>{{ $appointment->remarks }}</textarea>
                        </div>

                        <!-- Diagnostic -->
                        <div class="col-span-2">
                            <x-input-label for="diagnosis" :value="__('Veterinar Diagnostic')" />
                            <textarea rows="3" id="diagnosis"
                                class="block mt-1 w-full rounded p-2 border border-gray-300 text-slate-400"
                                name="diagnosis" disabled>{{ $appointment->diagnosis }}</textarea>
                        </div>

                        {{-- Extra Services --}}
                        <div class="flex-1 flex flex-col space-y-3 col-span-2">
                            <x-input-label :value="__('Extra Services')" />
                            <div class="grid grid-cols-3 gap-3">
                                @foreach ($services as $service)
                                    <div
                                        class='flex items-center gap-3  {{ $appointment->service->contains($service->id) ? "" : "hidden" }}'>
                                        <input type="checkbox" name="services[]" id="service_{{ $service->id }}"
                                            value="{{ $service->id }}" {{ $appointment->service->contains($service->id) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200"
                                            disabled />
                                        <label for="service_{{ $service->id }}">
                                            {{ $service->name }}<br />
                                            <span class="text-sm text-gray-500">(RM
                                                {{ number_format($service->price, 2) }})</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-span-2">
                            <x-input-label for="status" :value="__('Status')" />
                            @if(in_array(auth()->user()->role, ['staff', 'veterinar']))
                                <select name="status" id="status"
                                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                    disabled>
                                    <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="Approved" {{ $appointment->status == 'Approved' ? 'selected' : '' }}>
                                        Approved</option>
                                    <option value="Completed" {{ $appointment->status == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="Cancelled" {{ $appointment->status == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            @else
                                <x-text-input class="block mt-1 w-full text-gray-400" type="text" disabled
                                    value="{{ $appointment->status }}" />
                                <input type="hidden" name="status" value="{{ $appointment->status }}">
                            @endif
                        </div>

                        <div class="flex gap-2 items-center">
                            <a href="{{ url()->previous() }}">
                                <x-secondary-button>
                                    {{ __('Back') }}
                                </x-secondary-button>
                            </a>
                            <a href="{{ route('appointment.print', $appointment->id) }}">
                                <x-secondary-button>
                                    {{ __('Print') }}
                                </x-secondary-button>
                            </a>
                        </div>


                        @if ($errors->any())
                            <div class="mb-4 col-span-2">
                                <ul class="list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
