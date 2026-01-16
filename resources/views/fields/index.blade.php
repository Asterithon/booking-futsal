<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lapangan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded shadow">

                <table class="w-full border-collapse">
    <thead>
        <tr class="border-b">
            <th class="text-left py-2">Nama Lapangan</th>
            <th class="text-left py-2">Deskripsi</th>
            <th class="text-left py-2">Harga per Jam</th>
            <th class="text-left py-2">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($fields as $field)
            <tr class="border-b">
                <td class="py-2">
                    {{ $field->name }}
                </td>
                <td class="py-2">
                    {{ $field->description ?? '-' }}
                </td>
                <td class="py-2">
                    Rp {{ number_format($field->price_per_hour, 0, ',', '.') }}
                </td>
                <td class="py-2">
                    <span class="px-2 py-1 text-sm rounded
                        {{ $field->status === 'available'
                            ? 'bg-green-200 text-green-800'
                            : 'bg-yellow-200 text-yellow-800' }}">
                        {{ ucfirst($field->status) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="py-4 text-center text-gray-500">
                    Belum ada data lapangan
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

            </div>

        </div>
    </div>
</x-app-layout>
