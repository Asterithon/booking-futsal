<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Booking Lapangan</h2>
    </x-slot>

    <style>
        @keyframes pulse-red {
            0% { background-color: #dc2626; color: white; }
            20% { background-color: #f87171; color: white; }
        }

    .pulse-red {
        animation: pulse-red 0.2s ease;
    }
    </style>

    <div class="max-w-xl mx-auto py-6">
        <form method="POST" action="{{ route('booking.store') }}" id="bookingForm">
            @csrf

            <!-- Nama Tim -->
            <div class="mb-4">
                <label class="block mb-1">Nama Tim</label>
                <input type="text" name="team_name"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('team_name') }}" required>
            </div>

            <!-- No Telp -->
            <div class="mb-4">
                <label class="block mb-1">No. Telepon</label>
                <input type="text" name="phone"
                    class="w-full border rounded px-3 py-2"
                    value="{{ old('phone') }}" required>
            </div>

            <!-- Tanggal -->
            <div class="mb-4">
                <label class="block mb-1">Tanggal</label>
                    <input type="date"
                    name="booking_date"
                    value="{{ old('booking_date') }}"
                    class="w-full border px-3 py-2 rounded"
                    required>
            </div>


            <!-- Pilih Jam -->
            <div class="mb-4">
    <label class="block mb-2">Pilih Jam Bermain</label>

    <div class="grid grid-cols-3 gap-2">
        @for ($i = 9; $i <= 21; $i++)
            <button type="button"
                data-hour="{{ $i }}"
                class="time-btn border rounded py-2 text-center flex flex-col items-center">
                <span class="time-text">
                    {{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i+1) }}
                </span>
                <!-- label akan ditambahkan di sini -->
            </button>
        @endfor
    </div>
</div>

            <input type="hidden" name="start_hour" id="startHour">
            <input type="hidden" name="end_hour" id="endHour">


            <!-- Preview & set Harga -->
            <div class="mb-4">
                <p class="font-semibold">
                    Total Harga:
                    <span id="totalPrice">Rp 0</span>
                </p>
                <input type="hidden" name="total_price" id="totalPriceInput">
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-4">
                <label class="block mb-2">Metode Pembayaran</label>
                <label class="mr-4">
                    <input type="radio" name="payment_method" value="cash" required>
                    Bayar di Tempat
                </label>
                <label>
                    <input type="radio" name="payment_method" value="qris">
                    QRIS
                </label>
            </div>
            <a href="{{ url()->previous() }}" class="btn btn-secondary mr-4">
                ← Kembali
            </a>

            <button id="submitBtn" class="bg-blue-600 text-white px-4 py-2 rounded">
                Lanjutkan
            </button>

        </form>
    </div>
</x-app-layout>

<script>
    document.getElementById('bookingForm').addEventListener('submit', function (e) {
        const start = document.getElementById('startHour').value;
        const end   = document.getElementById('endHour').value;

        if (!start || !end) {
            e.preventDefault();
            alert('Silakan pilih jam bermain terlebih dahulu');
        }
    });

    const buttons = document.querySelectorAll('.time-btn');
    const startInput = document.getElementById('startHour');
    const endInput = document.getElementById('endHour');
    const priceEl = document.getElementById('totalPrice');
    const priceInput = document.getElementById('totalPriceInput');

    let start = null;
    let end = null;
    const pricePerHour = "{{ $field->price_per_hour }}";

    buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        const hour = parseInt(btn.dataset.hour);

        // Jika ada start dan end, cek apakah klik di luar range
        if (start !== null && end !== null && (hour < start || hour >= end)) {
            // Tambahkan efek pulse merah ke semua tombol yang sedang selected
            buttons.forEach(b => {
                const h = parseInt(b.dataset.hour);
                if (h >= start && h < end) {
                    b.classList.remove('bg-blue-600', 'text-white');
                    b.classList.add('pulse-red');
                    // Hapus efek setelah selesai animasi
                    setTimeout(() => b.classList.remove('pulse-red'), 500);
                }
            });
            // Reset state
            start = null;
            end = null;
            updateUI();
            return; // keluar supaya tidak lanjut logika lain
        }

        // Deselect jika klik jam yang sama dengan start
        if (start === hour && end === null) {
            start = null;
            end = null;
        }
        // Set start baru
        else if (start === null || (start !== null && end !== null)) {
            start = hour;
            end = null;
        }
        // Set end jika lebih besar dari start
        else if (hour > start) {
            end = hour + 1;
        }
        // Pindahkan start jika klik jam lebih kecil
        else if (hour < start) {
            end = start + 1;
            start = hour;
        }

        updateUI();
    });
});

    function updateUI() {
    buttons.forEach(btn => {
        const h = parseInt(btn.dataset.hour);
        btn.classList.remove('bg-blue-600', 'text-white');

        // Hapus label lama
        let label = btn.querySelector('.label');
        if (label) label.remove();

        // Highlight jam yang dipilih
        if (start !== null && end !== null && h >= start && h < end) {
            btn.classList.add('bg-blue-600', 'text-white');
        } else if (start !== null && end === null && h === start) {
            btn.classList.add('bg-blue-600', 'text-white');
        }

        // Tambahkan label
        if (start !== null && h === start) {
            const span = document.createElement('span');
            span.classList.add('label', 'text-xs', 'mt-1');
            span.innerText = "Jam Mulai";
            btn.appendChild(span);
        }
        if (end !== null && h === end - 1) {
            const span = document.createElement('span');
            span.classList.add('label', 'text-xs', 'mt-1');
            span.innerText = "Jam Selesai";
            btn.appendChild(span);
        }
    });

    // Hitung harga
    if (start !== null && end !== null) {
        const hours = end - start;
        startInput.value = start;
        endInput.value = end;
        priceInput.value = hours * pricePerHour;
        priceEl.innerText = 'Rp ' + (hours * pricePerHour).toLocaleString();
        
    } else if (start !== null && end === null) {
        // Anggap 1 jam kalau hanya pilih start
        startInput.value = start;
        endInput.value = start + 1;
        priceInput.value = 1 * pricePerHour;
        priceEl.innerText = 'Rp ' + (1 * pricePerHour).toLocaleString();
    } else {
        // Reset kalau tidak ada pilihan
        startInput.value = '';
        endInput.value   = '';
        priceInput.value = '';
        priceEl.innerText = 'Rp 0';
    }
}
</script>
