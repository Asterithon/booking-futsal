<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Booking</h2>
    </x-slot>

    <div class="max-w-xl mx-auto py-6">

        <form method="POST"
              action="{{ route('bookings.update', $booking) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama Tim</label>
                <input name="team_name"
                       class="w-full border px-3 py-2"
                       value="{{ $booking->team_name }}">
            </div>

            <div class="mb-3">
                <label>No Telp</label>
                <input name="phone"
                       class="w-full border px-3 py-2"
                       value="{{ $booking->phone }}">
            </div>

            <div class="mb-3">
                <label>Jam Mulai</label>
                <input type="number" name="start_hour"
                       value="{{ substr($booking->start_time,0,2) }}"
                       class="border px-3 py-2 w-full">
            </div>

            <div class="mb-3">
                <label>Jam Selesai</label>
                <input type="number" name="end_hour"
                       value="{{ substr($booking->end_time,0,2) }}"
                       class="border px-3 py-2 w-full">
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded">
                Simpan Perubahan
            </button>
        </form>

    </div>
</x-app-layout>
