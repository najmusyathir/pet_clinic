<!-- resources/views/components/sidebar.blade.php -->

<aside class="z-50 h-full">
    <div class="flex flex-col justify-between h-full">
        <nav class="py-6 flex flex-col text-[#3b2f63]">
            <a href="{{ route('dashboard') }}" class="p-6 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Dashboard</a>
            <a href="{{ route('users') }}" class="p-6 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Users</a>
            <a href="{{ route('profile.edit') }}" class="p-6 py-3 hover:text-[#261d44] hover:bg-[#b098ff79] transition">Settings</a>
            {{-- <a href="{{ route('appointments.index') }}" class="hover:text-[#261d44] transition">Appointments</a>
            <a href="{{ route('pets.index') }}" class="hover:text-[#261d44] transition">My Pets</a>
            <a href="{{ route('medical.index') }}" class="hover:text-[#261d44] transition">Medical History</a>
            <a href="{{ route('products.index') }}" class="hover:text-[#261d44] transition">Products & Services</a>
            <a href="{{ route('profile.edit') }}" class="hover:text-[#261d44] transition">Profile</a> --}}
        </nav>
    </div>
</aside>
