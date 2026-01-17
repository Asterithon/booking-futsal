<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Tambah Lapangan</h2>
    </x-slot>

    <form method="POST" action="{{ route('fields.store') }}"
          enctype="multipart/form-data"
          class="max-w-xl mx-auto py-6 space-y-4">
        @csrf

        <input class="w-full border p-2" name="name" placeholder="Nama Lapangan" required>

        <textarea class="w-full border p-2" name="description"
                  placeholder="Deskripsi (opsional)"></textarea>

        <input class="w-full border p-2" type="number"
               name="price_per_hour" placeholder="Harga per jam" required>

        <select name="status" class="w-full border p-2">
            <option value="available">Available</option>
            <option value="maintenance">Maintenance</option>
            <option value="disabled">Disabled</option>
        </select>

        <div>
            <label class="block mb-1 font-medium">Gambar Utama</label>
            <input type="file" name="primary_image" required>
        </div>

        <div>
    <label class="font-semibold">Gambar Tambahan</label>

    <div id="extraImages" class="space-y-2 mt-2"></div>

    <button type="button"
        onclick="addImageInput()"
        class="mt-2 px-3 py-1 bg-gray-200 rounded">
        + Tambah Gambar
    </button>
</div>


        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan
        </button>
    </form>
</x-app-layout>

<script>
function addImageInput() {
    const wrapper = document.getElementById('extraImages');

    const div = document.createElement('div');
    div.className = 'flex items-center gap-2';

    div.innerHTML = `
        <input type="file" name="images[]" class="border p-1">
        <button type="button"
            onclick="this.parentElement.remove()"
            class="text-red-600 font-bold">×</button>
    `;

    wrapper.appendChild(div);
}
</script>
