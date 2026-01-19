<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Detail Booking</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6 space-y-3">
<div class="bg-white p-4 rounded shadow">
        <p class="py-2"><b>Nama Tim:</b> {{ $booking->team_name }}</p>
        <p class="py-2"><b>No Telp:</b> {{ $booking->phone }}</p>
        <p class="py-2"><b>Lapangan:</b> {{ $booking->field->name }}</p>
        <p class="py-2"><b>Tanggal:</b> {{ $booking->booking_date->format('d-m-Y') }}</p>
        <p class="py-2"><b>Jam:</b>
            {{ date('H:i', strtotime($booking->start_time)) }}
            -
        {{ date('H:i', strtotime($booking->end_time)) }}
        </p>
        <p class="py-2"><b>Pembayaran:</b> {{ $booking->payment_method }}</p>
        <p class="py-2"><b>Status:</b> {{ ucfirst($booking->status) }}</p>

        <!-- STATUS ACTION -->
        <form method="POST"
              action="{{ route('bookings.status', $booking) }}"
              class="flex gap-2">
            @csrf
            @method('PATCH')

            <select name="status" class="border rounded px-3 py-2 pr-5">
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="completed">Completed</option>
            </select>

            <button class="bg-blue-600 text-white px-4 rounded">
                Update Status
            </button>
        </form>

        <!-- CANCEL -->
        <form method="POST"
              action="{{ route('bookings.cancel', $booking) }}"
              class="mt-4">
            @csrf
            @method('DELETE')

            <input type="text" name="reason"
                   placeholder="Alasan pembatalan"
                   class="border w-full px-3 py-2 mb-2" required>

            <button class="bg-red-600 text-white px-4 py-2 rounded">
                Batalkan Booking
            </button>
        </form>
</div>
    </div>
</x-app-layout>
