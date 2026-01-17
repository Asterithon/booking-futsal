<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\FieldImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with('primaryImage')->orderBy('name')->get();
    return view('fields.index', compact('fields'));
    }


    public function create()
{
    return view('fields.create');
}

public function edit(Field $field)
{
    $field->load('images');
    return view('fields.edit', compact('field'));
}



    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price_per_hour' => 'required|integer',
        'status' => 'required|in:available,maintenance,disabled',
        'primary_image' => 'required|image',
        'images.*' => 'nullable|image',
    ]);

    $field = Field::create($data);

    // Simpan gambar utama
    $primaryPath = $request->file('primary_image')
        ->store('fields', 'public');

    $field->images()->create([
        'image_path' => $primaryPath,
        'is_primary' => true,
    ]);

    // Gambar tambahan
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('fields', 'public');
            $field->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('fields.index')
        ->with('success', 'Lapangan berhasil ditambahkan');
}


public function update(Request $request, Field $field)
{
    $data = $request->validate([
        'name' => 'required|string',
        'description' => 'nullable|string',
        'price_per_hour' => 'required|integer',
        'status' => 'required|in:available,maintenance,disabled',
        'primary_image' => 'nullable|image',
        'images.*' => 'nullable|image',
        'remove_images' => 'nullable|array',
    ]);

    $field->update($data);

    /**
     * HAPUS GAMBAR YANG DICENTANG
     */
    if ($request->filled('remove_images')) {
        $images = $field->images()
            ->whereIn('id', $request->remove_images)
            ->get();

        foreach ($images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }
    }

    /**
     * GANTI PRIMARY IMAGE
     */
    if ($request->hasFile('primary_image')) {
        $old = $field->images()->where('is_primary', true)->first();

        if ($old) {
            Storage::disk('public')->delete($old->image_path);
            $old->delete();
        }

        $path = $request->file('primary_image')
            ->store('fields', 'public');

        $field->images()->create([
            'image_path' => $path,
            'is_primary' => true,
        ]);
    }

    /**
     * TAMBAH GAMBAR BARU
     */
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('fields', 'public');
            $field->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('fields.index')
        ->with('success', 'Lapangan berhasil diperbarui');
}





    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('fields.index');
    }
}
