<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Add Appointment') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 max-w-4xl">

                    <form method="POST" action="{{ route('appointment.create') }}" class="grid grid-cols-2 gap-6">
                        @csrf

                        <!-- Owner -->
                        <div>
                            <x-input-label for="Customer" :value="__('Customer Name')" />
                            <input type="hidden" name="customer_id" value={{auth()->user()->id}} />
                            <x-text-input class="block mt-1 w-full text-gray-400" type="text" disabled
                                value='{{ auth()->user()->name }}' disabled />
                        </div>

                        <!-- Pet -->
                        <div class="flex-1 flex flex-col">
                            <x-input-label for="pet" :value="__('Pet')" />
                            <select name='pet_id' id='pet_id'
                                class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'
                                required>

                                @if (count($pets) != 0)
                                    @foreach ($pets as $pet)
                                        <option value='{{$pet->id}}'>{{$pet->name}}
                                        </option>
                                    @endforeach
                                @endif

                            </select>
                            @if (count($pets) == 0)
                                <small class="text-red-600 py-2">Please add your pet first in <a href="{{route('pet.add')}}"
                                        class="text-blue-600 underline">My Pets</a>
                                </small>
                            @endif
                        </div>

                        <!-- Appointment Date -->
                        <div>
                            <x-input-label for="appointment_date" :value="__('Appointment Date')" />
                            <x-text-input id="appointment_date" class="block mt-1 w-full" type="date"
                                name="appointment_date" :value="old('appointment_date')" required />
                        </div>

                        <!-- Appointment Time -->
                        <div>
                            <x-input-label for="appointment_time" :value="__('Appointment Time')" />
                            <x-text-input id="appointment_time" class="block mt-1 w-full" type="time"
                                name="appointment_time" :value="old('appointment_time')" step="1800" min="08:00"
                                max="20:00" required />
                        </div>

                        <!-- Remarks-->
                        <div class="col-span-2">
                            <x-input-label for="remarks" :value="__('Remarks')" />
                            <Textarea rows="3" id="remarks" class="block mt-1 w-full rounded p-2 border border-gray-300"
                                name="remarks" :value="old('remarks')" required></Textarea>
                        </div>

                        {{-- Extra Services --}}
                        <div class="flex-1 flex flex-col space-y-3 col-span-2">
                            <x-input-label :value="__('Extra Services')" />

                            <div class="grid grid-cols-3 gap-3">
                                @foreach ($services as $service)
                                    <div class='flex items-center gap-3'>
                                        <input type="checkbox" name="services[]" id="service_{{ $service->id }}"
                                            value="{{ $service->id }}"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring focus:ring-indigo-200" />
                                        <label for="service_{{ $service->id }}">
                                            {{ $service->name }}<br />
                                            <span class="text-sm text-gray-500">(RM
                                                {{ number_format($service->price, 2) }})</span>
                                        </label>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <x-text-input id="status" class="block mt-1 w-full" type="hidden" name="status" value="Pending"
                            required />

                        <div class="flex items-center">
                            <x-primary-button>
                                {{ __('Add') }}
                            </x-primary-button>
                        </div>

                        @if ($errors->any())
                            <div class="mb-4">
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
