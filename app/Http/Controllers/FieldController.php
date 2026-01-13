<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::all();
        return view('fields.index', compact('fields'));
    }


    public function create()
    {
        return view('fields.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price_per_hour' => 'required|integer'
        ]);


        Field::create($request->all());
        return redirect()->route('fields.index');
    }


    public function edit(Field $field)
    {
        return view('fields.edit', compact('field'));
    }


    public function update(Request $request, Field $field)
    {
        $field->update($request->all());
        return redirect()->route('fields.index');
    }


    public function destroy(Field $field)
    {
        $field->delete();
        return redirect()->route('fields.index');
    }
}
