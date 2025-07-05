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
                    {{ auth()->user()->role == 'customer' ? __('My ') : '' }}{{ __('Pets') }}
                </h2>

                <a href="{{route('pet.add')}}">
                    <x-primary-button>Add Pet</x-primary-button>
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-5">

                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full border border-gray-200 divide-y divide-gray-200 shadow-sm rounded-lg py-1">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">No.</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Type</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                    @if (auth()->user()->role != 'customer')
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Pet Owner</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Gender</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Birth Date</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @if (count($pets) == 0)
                                    <tr>
                                        <td colspan="6" class="p-6 text-center">No Pet Found.</td>
                                    </tr>
                                @else
                                    @foreach ($pets as $index => $pet)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $pet->type }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $pet->name }}</td>
                                            @if (auth()->user()->role != 'customer')
                                                <td class="px-6 py-4 text-sm text-gray-900">{{ $pet->owner->name }}</td>
                                            @endif
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $pet->gender }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $pet->birth_date->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4"> <a href="{{ route('pet.detail', $pet->id) }}">
                                                    <x-primary-button>Edit</x-primary-button>
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
        </div>
    </div>
</x-app-layout>
