<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manajemen Booking</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <!-- FILTER -->
        <div class="bg-white p-4 rounded shadow">
        <form method="GET" class="flex gap-2">
            <select name="date" class="border rounded pl-3 pr-9 py-2">
                <option value="">Semua</option>
                <option value="today">Hari Ini</option>
                <option value="tomorrow">Besok</option>
            </select>

            <input type="date" name="date"
                   class="border rounded px-3 py-2">

            <button class="bg-gray-700 text-white px-4 rounded">
                Filter
            </button>

            <!-- TOMBOL MANUAL BOOKING -->
            <a href="{{ route('booking.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                + Manual Booking
            </a>

        </form>
</div>
        <!-- TABLE BOOKING AKTIF -->
         <div class="bg-white p-4 mt-6 rounded shadow">
        <table class="w-full border text-sm mb-8">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-2">Tanggal</th>
                    <th class="border px-2 py-2">Tim</th>
                    <th class="border px-2 py-2">Lapangan</th>
                    <th class="border px-2 py-2">Jam</th>
                    <th class="border px-2 py-2">Pembayaran</th>
                    <th class="border px-2 py-2">Status</th>
                    <th class="border px-2 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $filteredBookings = $bookings->where('status', '!=', 'cancelled');
                @endphp

                @forelse($filteredBookings as $booking)
                <tr>
                    <td class="border px-2 py-2">
                        {{ $booking->booking_date->format('d-m-Y') }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ $booking->team_name }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ $booking->field->name }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ date('H:i', strtotime($booking->start_time)) }}
                        -
                        {{ date('H:i', strtotime($booking->end_time)) }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ strtoupper($booking->payment_method) }}
                        ({{ $booking->payment_status }})
                    </td>
                    <td class="border px-2 py-2">
                        <span class="px-2 py-1 rounded text-xs
                        @if($booking->status === 'pending') .bg-yellow-100 .text-yellow-700
                        @elseif($booking->status === 'confirmed') .bg-blue-100 .text-blue-700
                        @elseif($booking->status === 'completed') .bg-green-100 .text-green-700
                        @else .bg-red-100 .text-red-700 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td class="border px-2 py-2 space-x-2">
                        <a href="{{ route('bookings.show', $booking) }}"
                           class="text-blue-600">Detail</a>

                        <a href="{{ route('bookings.edit', $booking) }}"
                           class="text-yellow-600">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada jadwal booking 
                        @if(request('date') === 'today')
                            hari ini
                        @elseif(request('date') === 'tomorrow')
                            besok
                        @elseif(request('date'))
                            pada tanggal {{ \Carbon\Carbon::parse(request('date'))->format('d-m-Y') }}
                        @else
                            yang tersimpan
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- TABLE BOOKING CANCELLED -->
        <h3 class="text-lg font-semibold mb-2">Jadwal Dibatalkan</h3>
        <table class="w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-2 py-2">Tanggal</th>
                    <th class="border px-2 py-2">Tim</th>
                    <th class="border px-2 py-2">Lapangan</th>
                    <th class="border px-2 py-2">Jam</th>
                    <th class="border px-2 py-2">Pembayaran</th>
                    <th class="border px-2 py-2">Status</th>
                    <th class="border px-2 py-2">Alasan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings->where('status', 'cancelled') as $booking)
                <tr>
                    <td class="border px-2 py-2">
                        {{ $booking->booking_date->format('d-m-Y') }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ $booking->team_name }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ $booking->field->name }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ date('H:i', strtotime($booking->start_time)) }}
                        -
                        {{ date('H:i', strtotime($booking->end_time)) }}
                    </td>
                    <td class="border px-2 py-2">
                        {{ strtoupper($booking->payment_method) }}
                        ({{ $booking->payment_status }})
                    </td>
                    <td class="border px-2 py-2">
                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                            Cancelled
                        </span>
                    </td>
                    <td class="border px-2 py-2">
                        {{ $booking->cancel_reason ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Tidak ada jadwal yang dibatalkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div></div>
</x-app-layout>