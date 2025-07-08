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
                    {{ __('Services') }}
                </h2>
                <a href="{{route('service.add')}}">
                    <x-primary-button>Add Service</x-primary-button>
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
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Category</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Price</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @if (count($services) == 0)
                                    <tr>
                                        <td colspan="6" class="p-6 text-center">No Pet Found.</td>
                                    </tr>
                                @else
                                    @foreach ($services as $index => $service)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $index + 1 }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $service->category }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $service->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $service->price }}</td>
                                            </td>
                                            <td class="px-6 py-4 flex gap-3">
                                                <a href="{{ route('service.detail', $service->id) }}">
                                                    <x-primary-button>Edit</x-primary-button>
                                                </a>

                                                <form action="{{ route('service.destroy', $service->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button>Delete</x-danger-button>
                                                </form>
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
