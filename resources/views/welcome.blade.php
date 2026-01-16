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
            <h1 class="text-xl font-bold text-green-600">FutsalBooking</h1>
            <nav class="flex items-center gap-4">
                <a href="#about" class="hover:text-green-600">About</a>
                <a href="#features" class="hover:text-green-600">Nilai Plus</a>
                <a href="#contact" class="hover:text-green-600">Contact</a>

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
    <section class="pt-32 pb-20 bg-green-50 dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-4">Booking Lapangan Futsal Jadi Mudah ⚽</h2>
            <p class="text-lg mb-6">Pesan lapangan futsal favoritmu kapan saja, tanpa ribet.</p>
            <a href="{{ route('register') }}" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Mulai Booking</a>
        </div>
    </section>

    <!-- About Us -->
    <section id="about" class="py-20">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h3 class="text-3xl font-semibold mb-4">Tentang Kami</h3>
            <p class="text-gray-600 dark:text-gray-300">
                Kami hadir untuk memudahkan pemain futsal dalam mencari dan memesan lapangan dengan cepat.
                Dengan sistem online, kamu bisa cek jadwal, harga, dan langsung booking tanpa harus datang ke lokasi.
            </p>
        </div>
    </section>

    <!-- Nilai Plus -->
    <section id="features" class="py-20 bg-gray-100 dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-6">
            <h3 class="text-3xl font-semibold text-center mb-10">Kenapa Pilih Kami?</h3>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow">
                    <h4 class="font-bold mb-2">📅 Booking Mudah</h4>
                    <p>Cek jadwal lapangan secara real-time dan pesan langsung dari aplikasi.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow">
                    <h4 class="font-bold mb-2">💳 Pembayaran Online</h4>
                    <p>Bayar dengan berbagai metode, aman dan praktis.</p>
                </div>
                <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow">
                    <h4 class="font-bold mb-2">🏆 Lapangan Berkualitas</h4>
                    <p>Kami bekerja sama dengan lapangan futsal terbaik di kota kamu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" class="bg-green-600 text-white py-10 mt-20">
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