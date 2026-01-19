<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Booking Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <table class="w-full border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Tanggal</th>
                            <th class="text-left py-2">Lapangan</th>
                            <th class="text-left py-2">Jam</th>
                            <th class="text-left py-2">Total</th>
                            <th class="text-left py-2">Metode</th>
                            <th class="text-left py-2">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bookings as $booking)
                        <tr class="border-b">
                            <td class="py-2">
                                {{ $booking->booking_date->format('d-m-Y') }}
                            </td>
                            <td class="py-2">
                                {{ $booking->field->name }}
                            </td>
                            <td class="py-2">
                                {{ date('H:i', strtotime($booking->start_time)) }}
                                -
                                {{ date('H:i', strtotime($booking->end_time)) }}
                            </td>
                            <td class="py-2">
                                Rp {{ number_format($booking->total_price) }}
                            </td>
                            <td class="py-2">
                                {{ strtoupper($booking->payment_method) }} ({{ $booking->payment_status }})
                            </td>
                            <td class="py-2">
                                <span class="px-2 py-1 text-sm rounded
    {{ $booking->status === 'pending' 
        ? 'bg-yellow-200 text-yellow-800' 
        : ($booking->status === 'confirmed' 
            ? 'bg-green-200 text-green-800' 
            : 'bg-red-200 text-red-800') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-gray-500">
                                Belum ada riwayat booking
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</x-app-layout>