<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold">Kelola Lapangan</h2>

            <a href="{{ route('fields.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Lapangan
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        @if ($fields->isEmpty())
            <div class="text-gray-500 text-center py-10">
                Belum ada data lapangan.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($fields as $field)
                    <div class="bg-white rounded shadow overflow-hidden">

                        {{-- Gambar Utama --}}
                        <div class="h-48 bg-gray-100">
                            @if ($field->primaryImage)
                                <img src="{{ asset('storage/'.$field->primaryImage->image_path) }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    No Image
                                </div>
                            @endif
                        </div>

                        {{-- Konten --}}
                        <div class="p-4">
                            <h3 class="font-semibold text-lg">
                                {{ $field->name }}
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Rp {{ number_format($field->price_per_hour) }} / jam
                            </p>

                            {{-- Status --}}
                            <div class="mt-2">
                                @php
                                    $statusColor = match($field->status) {
                                        'available' => 'bg-green-100 text-green-700',
                                        'maintenance' => 'bg-yellow-100 text-yellow-700',
                                        'disabled' => 'bg-red-100 text-red-700',
                                    };
                                @endphp

                                <span class="text-xs px-2 py-1 rounded {{ $statusColor }}">
                                    {{ ucfirst($field->status) }}
                                </span>
                            </div>

                            {{-- Aksi --}}
                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('fields.edit', $field->id) }}"
                                   class="px-3 py-1 text-sm bg-gray-200 rounded hover:bg-gray-300">
                                    Edit
                                </a>

                                {{-- optional: detail --}}
                                {{-- 
                                <a href="{{ route('fields.show', $field->id) }}"
                                   class="px-3 py-1 text-sm bg-blue-100 rounded">
                                    Detail
                                </a>
                                --}}
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
