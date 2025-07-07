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

                        <div class="flex gap-3">
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
                            <div class="flex-1 flex flex-col">
                                <x-input-label for="gender" :value="__('Gender')" />
                                <select name='gender' id='gender'
                                    class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                    <option value='male' {{ $pet->gender == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value='female' {{ $pet->gender == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                </select>
                            </div>
                        </div>


                        <div class="flex items-center gap-3">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>

                            <a href={{route('pets')}}>
                                <x-secondary-button>
                                    {{ __('Cancel') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
        </div>
    </div>
</x-app-layout>
