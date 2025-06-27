<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Add Pet') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 max-w-3xl">

                    <form method="POST" action="{{ route('pet.create') }}" class="grid grid-cols-2 gap-6">
                        @csrf

                        <!-- Owner -->
                        <div>
                            <x-input-label for="Owner" :value="__('Owner')" />
                            <input type="hidden" name="owner_id" value={{auth()->user()->id}} />
                            <x-text-input class="block mt-1 w-full text-gray-400" type="text" disabled
                                value='{{ auth()->user()->name }}' disabled />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required />
                        </div>


                        <!-- Birth Date -->
                        <div>
                            <x-input-label for="birth_date" :value="__('Birth Date')" />
                            <x-text-input id="birth_date" class="block mt-1 w-full" type="date" name="birth_date"
                                :value="old('birth_date')" required />
                        </div>

                        <div class="flex gap-3">
                            <!-- Type -->
                            <div class="flex-1 flex flex-col">
                                <x-input-label for="type" :value="__('Type')" />
                                <select name='type' id='type'
                                    class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                    <option value='cat'>Cat
                                    </option>
                                    <option value='dog'>Dog
                                    </option>
                                    <option value='bird'>Bird
                                    </option>
                                    <option value='others'>Others
                                    </option>
                                </select>
                            </div>

                            <!-- Gender -->
                            <div class="flex-1 flex flex-col">
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select name='gender' id='gender'
                                    class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                    <option value='male'>Male
                                    </option>
                                    <option value='female'>Female
                                    </option>
                                </select>
                            </div>
                        </div>


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