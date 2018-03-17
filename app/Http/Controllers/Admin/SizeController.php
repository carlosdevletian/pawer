<?php

namespace Pawer\Http\Controllers\Admin;

use Pawer\Models\Size;
use Illuminate\Http\Request;
use Pawer\Http\Controllers\Controller;

class SizeController extends Controller
{
    public function index()
    {
        return view('admin.sizes.index', [
            'sizes' => Size::get()
        ]);
    }

    public function create()
    {
        return view('admin.sizes.create');
    }

    public function store()
    {
        $validatedData = request()->validate([
            'name' => ['required']
        ]);

        $size = Size::create($validatedData);

        return redirect()->route('admin.sizes.edit', $size);
    }

    public function edit($size)
    {
        return view('admin.sizes.edit', [
            'size' => Size::findOrFail($size)
        ]);
    }

    public function update($size)
    {
        $size = Size::findOrFail($size);

        $validatedData = request()->validate([
            'name' => ['required']
        ]);

        $size->update($validatedData);

        return redirect()->back();
    }
}
