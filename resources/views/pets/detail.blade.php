<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Pet Details') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 max-w-3xl">

                    <form method="POST" action="{{ route('pet.update', $pet->id) }}" class="grid grid-cols-2 gap-6">
                        @method('PUT')
                        @csrf

                        <!-- Owner -->
                        <div>
                            <x-input-label for="Owner" :value="__('Owner')" />
                            <x-text-input class="block mt-1 w-full text-gray-400" type="text" disabled
                                value='{{ $pet->owner->name }}' disabled />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required value='{{ $pet->name }}' />
                        </div>


                        <!-- Birth Date -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Birth Date')" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date"
                                :value="old('birth_date', $pet->birth_date->format('Y-m-d'))" required />
                        </div>

                        <!-- Type -->
                        <div class="flex-1 flex flex-col">
                            <x-input-label for="type" :value="__('Type')" />
                            <select name='type' id='type'
                                class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                </option>
                                <option value='Maine Coon' {{ $pet->type == 'Maine Coon' ? 'selected' : '' }}>Maine
                                    Coon
                                </option>
                                <option value='Persian' {{ $pet->type == 'Persian' ? 'selected' : '' }}>Persian
                                </option>
                                <option value='BSH' {{ $pet->type == 'BSH' ? 'selected' : '' }}>British Short Hair -
                                    BSH
                                </option>
                                <option value='Scottish Fold' {{ $pet->type == 'Scottish Fold' ? 'selected' : '' }}>
                                    Scottish Fold
                                </option>
                                <option value='Siamese' {{ $pet->type == 'Siamese' ? 'selected' : '' }}>Siamese
                                </option>
                                <option value='Bengal' {{ $pet->type == 'Bengal' ? 'selected' : '' }}>Bengal
                                </option>
                                <option value='Ragdoll' {{ $pet->type == 'Ragdoll' ? 'selected' : '' }}>Ragdoll
                                </option>
                                <option value='Munchkin' {{ $pet->type == 'Munchkin' ? 'selected' : '' }}>Munchkin
                                </option>
                                <option value='kampung' {{ $pet->type == 'kampung' ? 'selected' : '' }}>Kampung Cat -
                                    Local Mixed Breed
                                </option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div class="flex-1 flex flex-col col">
                            <x-input-label for="gender" :value="__('Gender')" />
                            <select name='gender' id='gender'
                                class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                <option value='male' {{ $pet->gender == 'male' ? 'selected' : '' }}>Male
                                </option>
                                <option value='female' {{ $pet->gender == 'female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>

                        <div></div>

                        <div class="flex items-center gap-3 print:hidden">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>

                            <a href={{route('pets')}}>
                                <x-secondary-button>
                                    {{ __('Cancel') }}
                                </x-secondary-button>
                            </a>

                            <a onclick="window.print()">
                                <x-secondary-button>
                                    Print
                                </x-secondary-button>
                            </a>

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg print:hidden">
                <div class="p-8 max-w-3xl space-y-4">
                    <h5>Remove<span class="p-1 mx-1 text-sm border rounded border-red-800 text-red-800 bg-red-100">
                            {{$pet->name}}
                        </span> from pet list
                    </h5>


                    <form action="{{ route('pet.destroy', $pet->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure to remove {{$pet->name}} from your pet?')">
                        @csrf
                        @method('DELETE')
                        <x-danger-button>Remove This Pet</x-danger-button>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 max-w-3xl space-y-4">

                    <div class="flex gap-3 items-center">
                        <h2 class="text-xl">Diagnosis History</h2>
                    </div>
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200 shadow-sm rounded-lg py-1">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No.</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 text-nowrap">Date</th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Veterinar Diagnosis
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 print:hidden">Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            {{-- {{$appointments}} --}}
                            @if (count($appointments) == 0)
                                <tr>
                                    <td colspan="6" class="p-6 text-center">No Appointment Found.</td>
                                </tr>
                            @else
                                @foreach ($appointments as $index => $appointment)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $appointment->appointment_date->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $appointment->diagnosis }}</td>
                                        </td>
                                        <td class="px-6 py-4 flex gap-3 print:hidden">
                                            <a href="{{ route('history.detail', $appointment->id) }}">
                                                <x-primary-button>Details</x-primary-button>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Hide on print --}}
        <style>
            @media print {

                .print\:hidden,
                .the-drawer,
                .the-navbar {
                    display: none !important;
                }
            }
        </style>
</x-app-layout>
