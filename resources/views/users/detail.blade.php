<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('List of all users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl space-y-6 gap-6 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-400 max-w-3xl">
                    <form method="POST" action="{{ route('user.updateRole', $user->id) }}">
                        @method('PUT')
                        @csrf

                        <!-- Name -->
                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" value='{{ $user->name }}'
                                disabled />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                                :value="old('phone')" required autofocus autocomplete="phone" value='{{ $user->phone }}'
                                disabled />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email')" required autocomplete="email" value='{{ $user->email }}'
                                disabled />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Role -->
                        <div class="mt-4 text-gray-800">
                            <x-input-label for="role" :value="__('Role')" />
                            <select name='role' id='role'
                                class='mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'>
                                <option value='veterinar' {{ $user->role == 'veterinar' ? 'selected' : '' }}>Veterinar
                                </option>
                                <option value='staff' {{ $user->role == 'staff' ? 'selected' : '' }}>Clinic Staff
                                </option>
                                <option value='customer' {{ $user->role == 'customer' ? 'selected' : '' }}>Customer
                                </option>

                            </select>
                        </div>

                        <div class="flex items-center mt-4">
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-400 max-w-3xl space-y-2">
                    <x-input-label :value="__('Reset password for this user?')" />

                    <form action="{{ route('user.resetPassword', $user->id) }}" method="POST"
                        onsubmit="return confirm('Confrm reset password to default? (password123)')">
                        @csrf
                        @method('PUT')
                        <x-danger-button>Reset Password</x-danger-button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>