<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Edit Lapangan</h2>
    </x-slot>

    <form method="POST"
          action="{{ route('fields.update', $field) }}"
          enctype="multipart/form-data"
          class="max-w-xl mx-auto py-6 space-y-4">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <input class="w-full border p-2"
               name="name"
               value="{{ $field->name }}"
               required>

        <!-- Deskripsi -->
        <textarea class="w-full border p-2"
                  name="description"
                  placeholder="Deskripsi lapangan">{{ $field->description }}</textarea>

        <!-- Harga -->
        <input class="w-full border p-2"
               type="number"
               name="price_per_hour"
               value="{{ $field->price_per_hour }}"
               required>

        <!-- Status -->
        <select name="status" class="w-full border p-2">
            @foreach (['available','maintenance','disabled'] as $status)
                <option value="{{ $status }}"
                    @selected($field->status === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <!-- PREVIEW GAMBAR EXISTING -->
        @if ($field->images->count())
    <div>
        <label class="font-semibold block mb-2">Gambar Saat Ini</label>

        <div class="grid grid-cols-2 gap-4">
            @foreach ($field->images as $img)
                <div class="relative border rounded p-2 image-card">
    <img src="{{ asset('storage/'.$img->image_path) }}"
         class="w-full h-32 object-cover rounded">

    @if ($img->is_primary)
        <span class="absolute bottom-1 left-1
            text-xs bg-black text-white px-2 py-0.5 rounded">
            Primary
        </span>
    @else
        <input type="checkbox"
               name="remove_images[]"
               value="{{ $img->id }}"
               class="hidden remove-checkbox">

        <button type="button"
            class="remove-toggle absolute top-1 right-1
                   bg-white rounded-full px-2 py-0.5
                   text-red-600 font-bold">
            ×
        </button>

        <span class="remove-label hidden cursor-pointer
            absolute inset-0 bg-red-600/70 text-white
            flex items-center justify-center text-sm font-semibold rounded">
            Ditandai untuk dihapus
        </span>
    @endif
</div>

            @endforeach
        </div>
    </div>
@endif


        <!-- GANTI PRIMARY IMAGE -->
        <div>
            <label class="block font-semibold mb-1">
                Ganti Gambar Utama (opsional)
            </label>
            <input type="file" name="primary_image">
        </div>

        <!-- TAMBAH GAMBAR BARU (DINAMIS) -->
        <div>
            <label class="block font-semibold mb-1">
                Tambah Gambar Baru
            </label>

            <div id="extraImages" class="space-y-2"></div>

            <button type="button"
                onclick="addImageInput()"
                class="mt-2 px-3 py-1 bg-gray-200 rounded">
                + Tambah Gambar
            </button>
        </div>

        <!-- SUBMIT -->
        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Update Lapangan
        </button>
    </form>
</x-app-layout>

<script>
function addImageInput() {
    const container = document.getElementById('extraImages');

    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';

    div.innerHTML = `
        <input type="file" name="images[]" class="border p-1 flex-1">
        <button type="button"
            onclick="this.parentElement.remove()"
            class="text-red-600 font-bold">
            ×
        </button>
    `;

    container.appendChild(div);
}

function markForRemoval(btn) {
    const card = btn.closest('.image-card');
    const input = card.querySelector('input[name="remove_images[]"]');

    input.disabled = false;

    card.classList.add('opacity-40', 'relative');
    btn.remove();
}

document.addEventListener('click', function (e) {

    // Klik tombol X
    if (e.target.classList.contains('remove-toggle')) {
        const card = e.target.closest('.image-card');
        toggleRemove(card);
    }

    // Klik overlay "Ditandai untuk dihapus" → BATAL
    if (e.target.classList.contains('remove-label')) {
        const card = e.target.closest('.image-card');
        toggleRemove(card);
    }

});

function toggleRemove(card) {
    const checkbox = card.querySelector('.remove-checkbox');
    const label = card.querySelector('.remove-label');

    checkbox.checked = !checkbox.checked;

    if (checkbox.checked) {
        card.classList.add('opacity-60', 'ring-2', 'ring-red-500');
        label.classList.remove('hidden');
    } else {
        card.classList.remove('opacity-60', 'ring-2', 'ring-red-500');
        label.classList.add('hidden');
    }
}
</script>
