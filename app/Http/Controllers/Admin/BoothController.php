<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booth;
use Illuminate\Http\Request;

class BoothController extends Controller
{
    public function index(Request $request)
    {
        $query = Booth::query();

        if ($request->filled('search')) {
            $query->where('nama_booth', 'like', '%' . $request->search . '%')
                  ->orWhere('status', 'like', '%' . $request->search . '%')
                  ->orWhere('kapasitas', 'like', '%' . $request->search . '%');
        }

        $booths = $query->latest()->paginate(10);

        return view('admin.booth.index', compact('booths'));
    }

    public function create()
    {
        return view('admin.booth.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:kosong,terpakai',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
        ]);

        Booth::create($request->all());

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil ditambahkan');
    }

    public function edit($id)
    {
        $booth = Booth::findOrFail($id);
        return view('admin.booth.edit', compact('booth'));
    }

    public function update(Request $request, $id)
    {
        $booth = Booth::findOrFail($id);

        $request->validate([
            'nama_booth' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required|in:kosong,terpakai',
            'jam_mulai' => 'nullable|date_format:H:i',
            'jam_selesai' => 'nullable|date_format:H:i',
        ]);

        $booth->update($request->all());

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil diperbarui');
    }

    public function destroy($id)
    {
        Booth::destroy($id);

        return redirect()->route('admin.booth.index')->with('success', 'Booth berhasil dihapus');
    }
}
