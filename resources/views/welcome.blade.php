<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-[#c9d6ff] via-[#e2e2e2] to-[#f2fcfe] flex flex-col items-center justify-center p-6">
    <div class="w-full max-w-5xl bg-white/30 backdrop-blur-md rounded-2xl shadow-xl p-10 border border-white/20">
        <header class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-[#3b2f63]">🐾 PetCare+</h1>
            <nav class="flex gap-4 text-sm">
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-[#3b2f63] hover:underline">
                        <x-primary-button>
                            Dashboard
                        </x-primary-button>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-[#3b2f63] hover:underline">
                        <x-secondary-button>
                            Log in
                        </x-secondary-button>
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-[#3b2f63] hover:underline">
                            <x-primary-button>
                                Register
                            </x-primary-button>
                        </a>
                    @endif
                @endauth
            </nav>
        </header>

        <main class="text-center space-y-12">
            <section>
                <h2 class="text-4xl font-bold text-[#3b2f63] mb-4">Smarter Pet Healthcare Starts Here</h2>
                <p class="text-[#1b1b18]/80 text-lg">Manage your pet’s medical history, appointments, and services from
                    one beautiful interface.</p>
            </section>

            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white/20 backdrop-blur rounded-xl p-6 shadow hover:shadow-lg transition-all border border-white/30">
                    <img src="/assets/icons/ic_device.svg" alt="Register Icon" class="w-12 h-12 mb-3 mx-auto">
                    <h3 class="text-xl font-semibold text-[#3b2f63]">Effortless Registration</h3>
                    <p class="text-sm text-[#1b1b18]/80">Get started in seconds. Create your profile and register your
                        pet instantly.</p>
                </div>
                <div
                    class="bg-white/20 backdrop-blur rounded-xl p-6 shadow hover:shadow-lg transition-all border border-white/30">
                    <img src="/assets/icons/ic_calendar.svg" alt="Appointment Icon" class="w-12 h-12 mb-3 mx-auto">
                    <h3 class="text-xl font-semibold text-[#3b2f63]">Book Appointments</h3>
                    <p class="text-sm text-[#1b1b18]/80">Choose a time, service, and vet—done. Never miss a check-up
                        again.</p>
                </div>
                <div
                    class="bg-white/20 backdrop-blur rounded-xl p-6 shadow hover:shadow-lg transition-all border border-white/30">
                    <img src="/assets/icons/ic_clipboard.svg" alt="Records Icon" class="w-12 h-12 mb-3 mx-auto">
                    <h3 class="text-xl font-semibold text-[#3b2f63]">Access Medical Records</h3>
                    <p class="text-sm text-[#1b1b18]/80">Stay informed with real-time access to your pet’s health
                        history and treatments.</p>
                </div>
            </section>

            <section>
                <a href="{{ route('register') }}"
                    class="mt-6 inline-block px-8 py-3 rounded-xl bg-gradient-to-r from-[#9D50BB] to-[#6E48AA] text-white shadow-lg hover:scale-105 transition">
                    Join PetCare+ Today
                </a>
            </section>
        </main>
    </div>
</body>

</html>
