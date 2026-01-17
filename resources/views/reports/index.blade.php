<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            Laporan Booking
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 space-y-8">
    <div
        id="report-data"
        data-booking-dates='@json($bookingDates)'
        data-booking-totals='@json($bookingTotals)'
        data-status-labels='@json($statusLabels)'
        data-status-totals='@json($statusTotals)'>
    </div>

        <!-- SECTION: FILTER (placeholder dulu) -->
        <div class="bg-white p-4 rounded shadow">
    <form method="GET" class="flex flex-wrap gap-4 items-end">

        <div>
            <label class="block text-sm font-medium">Dari Tanggal</label>
            <input type="date"
                   name="start_date"
                   value="{{ request('start_date', $start->toDateString()) }}"
                   class="border p-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Sampai Tanggal</label>
            <input type="date"
                   name="end_date"
                   value="{{ request('end_date', $end->toDateString()) }}"
                   class="border p-2 rounded">
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Terapkan Filter
        </button>

    </form>
</div>


        <!-- SECTION: CHART PLACEHOLDER -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- CHART: BOOKING PER HARI -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-2">Booking per Hari</h3>
        <canvas id="bookingPerDayChart" height="120"></canvas>
    </div>

    <!-- CHART: STATUS BOOKING -->
    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold mb-2">Status Booking</h3>
        <canvas id="statusChart" height="120"></canvas>
    </div>

</div>


        <!-- SECTION: TABLE DATA -->
        <div class="bg-white p-4 rounded shadow">
            <h3 class="font-semibold mb-4">
                Data Booking (Completed & Cancelled)
            </h3>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="border-b">
                        <tr class="text-left">
                            <th class="py-2">Tanggal</th>
                            <th>Lapangan</th>
                            <th>Tim</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                            <tr class="border-b">
                                <td class="py-2">
                                    {{ $booking->booking_date }}
                                </td>
                                <td>
                                    {{ $booking->field->name ?? '-' }}
                                </td>
                                <td>
                                    {{ $booking->team_name }}
                                </td>
                                <td>
                                    {{ substr($booking->start_time,0,5) }}
                                    -
                                    {{ substr($booking->end_time,0,5) }}
                                </td>
                                <td>
                                    <span class="px-2 py-1 rounded text-xs
                                        {{ $booking->status === 'completed'
                                            ? 'bg-green-100 text-green-700'
                                            : 'bg-red-100 text-red-700' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ strtoupper($booking->payment_method) }}
                                </td>
                                <td>
                                    Rp {{ number_format($booking->total_price) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-gray-500">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const dataEl = document.getElementById('report-data');

    const bookingDates  = JSON.parse(dataEl.dataset.bookingDates);
    const bookingTotals = JSON.parse(dataEl.dataset.bookingTotals);
    const statusLabels  = JSON.parse(dataEl.dataset.statusLabels);
    const statusTotals  = JSON.parse(dataEl.dataset.statusTotals);

    // LINE CHART
    new Chart(
        document.getElementById('bookingPerDayChart'),
        {
            type: 'line',
            data: {
                labels: bookingDates,
                datasets: [{
                    data: bookingTotals,
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        }
    );

    // DONUT CHART
    new Chart(
        document.getElementById('statusChart'),
        {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusTotals
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        }
    );

});
</script>


