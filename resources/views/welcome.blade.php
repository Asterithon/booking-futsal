<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <!-- Navbar -->
    <header class="w-full fixed top-0 bg-white dark:bg-gray-800 shadow z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <img src="{{ asset('images/app-logo.png') }}" alt="Logo" width="100">
            <nav class="flex items-center gap-4">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-3 py-1 rounded bg-gray-200 dark:bg-gray-700">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-1 rounded bg-gray-200 dark:bg-gray-700">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-3 py-1 rounded bg-green-600 text-white">Register</a>
                        @endif
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
<section class="relative h-[80vh] flex items-center justify-center">
    <!-- Background image -->
    <img src="{{ asset('images/hero.jpeg') }}"
         class="absolute inset-0 w-full h-full object-cover" />

    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 text-center text-white max-w-3xl">
        <h1 class="text-5xl md:text-6xl font-bold tracking-wide">
            SHOW YOUR SKILL
        </h1>

        <p class="mt-6 text-lg text-gray-200">
            Pesan lapangan. Pilih waktu. Tunjukkan skillmu.
        </p>

        <div class="mt-8 flex justify-center gap-4">
            <a href="{{ route('login') }}"
               class="px-6 py-3 bg-green-600 rounded text-white font-semibold">
                Booking Sekarang
            </a>

            
        </div>
    </div>
</section>


    <!-- About Us -->
    <section id="features" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-center mb-12">
            Fitur Unggulan
        </h2>

        <div class="grid md:grid-cols-3 gap-8 text-center">

            <div class="p-6 rounded-lg border">
                <div class="text-4xl mb-4">⚡</div>
                <h3 class="font-semibold text-xl mb-2">
                    Booking Pintar
                </h3>
                <p class="text-gray-600">
                    Pesan lapanganmu dalam hitungan detik tanpa telepon.
                </p>
            </div>

            <div class="p-6 rounded-lg border">
                <div class="text-4xl mb-4">📅</div>
                <h3 class="font-semibold text-xl mb-2">
                    Ketersediaan Real-Time
                </h3>
                <p class="text-gray-600">
                    Langsung tahu jam yang tersedia.
                </p>
            </div>

            <div class="p-6 rounded-lg border">
                <div class="text-4xl mb-4">⏱️</div>
                <h3 class="font-semibold text-xl mb-2">
                    Slot Waktu Fleksibel
                </h3>
                <p class="text-gray-600">
                    Pilih waktu mulai dan perpanjang tanpa jeda.
                </p>
            </div>

        </div>
    </div>
</section>


    <!-- Lapangan Tersedia -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">

        <h2 class="text-3xl font-bold text-center mb-12">
            Main di Lingkungan Terbaik
        </h2>

        <div class="grid md:grid-cols-3 gap-6">

            @foreach ([
                ['img' => 'pro.jpeg', 'text' => 'Professional Grade Field'],
                ['img' => 'night.jpeg', 'text' => 'Night Play Ready'],
                ['img' => 'comfort.jpeg', 'text' => 'Comfort & Safety'],
            ] as $item)

                <div class="relative overflow-hidden rounded-lg group">
                    <img src="{{ asset('images/' . $item['img']) }}"
                         class="w-full h-64 object-cover group-hover:scale-105 transition">

                    <div class="absolute inset-0 bg-black/40 flex items-end">
                        <p class="text-white p-4 font-semibold">
                            {{ $item['text'] }}
                        </p>
                    </div>
                </div>

            @endforeach

        </div>
    </div>
</section>

<section class="py-16 bg-green-600 text-white text-center">
    <h2 class="text-3xl font-bold mb-4">
        Siap Bermain?


    </h2>

    <p class="mb-6">
        Pilih waktumu dan amankan lapangan sekarang.
    </p>

    <a href="{{ route('booking.create') }}"
       class="px-8 py-3 bg-white text-green-600 rounded font-semibold">
        Start Booking
    </a>
</section>

    <!-- Footer -->
    <footer id="contact" class="bg-green-600 text-white py-10">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h4 class="text-lg font-semibold mb-2">Hubungi Kami</h4>
            <p>Email: support@futsalbooking.com | Telp: +62 812-3456-7890</p>
            <p class="mt-4">&copy; {{ date('Y') }} FutsalBooking. All rights reserved.</p>
        </div>
    </footer>

    <!-- Script Toggle Theme -->
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
        });
    </script>
</body>
</html>