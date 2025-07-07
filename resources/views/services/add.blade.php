<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Add Service') }}
            </h2>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 max-w-3xl">

                    <form method="POST" action="{{ route('service.create') }}" class="grid grid-cols-2 gap-6">
                        @csrf


                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required />
                        </div>

                        <!-- Category -->
                        <div class="flex-1 flex flex-col">
                            <x-input-label for="category" :value="__('Category')" />
                            <select name='category' id='category'
                                class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                <option value='General'>General
                                </option>
                                <option value='Neutering'>Neutering
                                </option>
                                <option value='Grooming'>Grooming
                                </option>
                                <option value='Lion Cut'>Lion Cut
                                </option>
                                <option value='Boarding'>Boarding
                                </option>
                                <option value='Others'>Others
                                </option>
                            </select>
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('Price (RM)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price"
                                :value="old('price')" required />
                        </div>

                        <div class="flex gap-3">
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
