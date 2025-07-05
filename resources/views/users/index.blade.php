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
                    List of All Users
                </h2>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full border border-gray-200 divide-y divide-gray-200 shadow-sm rounded-lg py-1">

                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Full Name</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Role</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Phone Number</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($users as $user)
                                    @if ($user->id != auth()->user()->id)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->role }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900">{{ $user->phone }}</td>
                                            <td class="px-6 py-4 flex gap-3 flex-wrap">
                                                <a href="{{ route('user.detail', $user->id) }}">
                                                    <x-primary-button>Edit</x-primary-button>
                                                </a>

                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-danger-button>Delete</x-danger-button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
