<x-app-layout>
    <div class="max-w-md mx-auto py-10 text-center">
        <h2 class="text-xl font-semibold mb-4">Pembayaran QRIS</h2>

        <p class="mb-6">Silakan lakukan pembayaran (simulasi)</p>

        <div class="flex justify-center gap-4">
            <a href="{{ route('booking.create') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded">
                Batalkan
            </a>

            <a href="{{ route('dashboard') }}"
               class="bg-green-600 text-white px-4 py-2 rounded">
                Bayar
            </a>
        </div>
    </div>
</x-app-layout>
