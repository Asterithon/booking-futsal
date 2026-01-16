<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>


    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


            <!-- INFO USER -->

            <div class="mb-6">
                <p class="text-gray-700">
                    Selamat datang, <strong>{{ auth()->user()->name }}</strong>
                </p>
                <p class="text-sm text-gray-500">
                    Role: {{ auth()->user()->role }}
                </p>
            </div>


            <!-- DASHBOARD ADMIN -->
            @if(auth()->user()->isAdmin())
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Menu Admin</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('fields.index') }}"
                        class="bg-blue-600 text-white text-center py-4 rounded hover:bg-blue-700">
                        Kelola Lapangan
                    </a>

                    <a href="{{ route('bookings.index') }}"
                        class="bg-yellow-600 text-white text-center py-4 rounded hover:bg-yellow-700">
                        booking
                    </a>

                    <a href="{{ route('reports.index') }}"
                        class="bg-green-600 text-white text-center py-4 rounded hover:bg-green-700">
                        Lihat Laporan
                    </a>

                    <a href="{{ route('users.index') }}"
                        class="bg-gray-700 text-white text-center py-4 rounded hover:bg-gray-800">
                        Kelola User
                    </a>

                </div>
            </div>
            @endif


            <!-- DASHBOARD CUSTOMER -->
            @if(auth()->user()->role === 'customer')
            <div class="bg-white p-6 rounded shadow">
                <h3 class="text-lg font-semibold mb-4">Menu Pelanggan</h3>


                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('booking.create') }}"
                        class="bg-indigo-600 text-white text-center py-4 rounded hover:bg-indigo-700">
                        Booking Lapangan
                    </a>


                    <a href="{{ route('booking.my') }}"
                        class="bg-gray-600 text-white text-center py-4 rounded hover:bg-gray-700">
                        Riwayat Booking
                    </a>

                </div>
            </div>
            @endif


        </div>
    </div>
</x-app-layout>