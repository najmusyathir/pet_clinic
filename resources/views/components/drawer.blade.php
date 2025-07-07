<!-- resources/views/components/sidebar.blade.php -->

<aside class="z-50 h-full">
    <div class="flex flex-col justify-between h-full">
        <nav class="py-6 flex flex-col text-[#3b2f63]">
            <a href="{{ route('dashboard') }}"
                class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Dashboard</a>
            @if (auth()->user()->role == 'veterinar' || auth()->user()->role == 'staff') <a href="{{ route('users') }}"
                class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Users</a>
            @endif

            <a href="{{ route('pets') }}" class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">
                {{ auth()->user()->role == 'customer' ? __('My ') : '' }}{{ __('Pets') }}
            </a>
            @if (auth()->user()->role == 'staff')
             <a href="{{ route('services') }}"
                class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Services</a>
            @endif

            <a href="{{ route('appointments') }}"
                class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Appointments</a>
            <a href="{{ route('histories') }}"
                class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Appointment History</a>
            <a href="{{ route('profile.edit') }}"
                class="p-12 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Settings</a>
        </nav>
    </div>
</aside>
