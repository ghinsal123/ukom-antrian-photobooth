<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    /**
     * Menampilkan daftar pengguna dengan fitur search & sorting role
     */
    public function index(Request $request)
    {
        $query = Pengguna::query();

        // Search berdasarkan nama, no telepon, atau role
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_pengguna', 'like', '%' . $request->search . '%')
                ->orWhere('no_telp', 'like', '%' . $request->search . '%')
                ->orWhere('role', 'like', '%' . $request->search . '%');
            });
        }

        // Urutkan: admin > operator > customer
        $query->orderByRaw("
            CASE 
                WHEN role = 'admin' THEN 1
                WHEN role = 'operator' THEN 2
                WHEN role = 'customer' THEN 3
                ELSE 4
            END
        ");

        // Urutkan berdasarkan tanggal pembuatan (terbaru)
        $query->orderBy('created_at', 'desc');

        // Paginasi 10 per halaman
        $pengguna = $query->paginate(10);
        return view('admin.pengguna.index', compact('pengguna'));
    }

    // Menampilkan hanya staff (admin + operator)
    public function staff(Request $request)
    {
        $pengguna = Pengguna::whereIn('role', ['admin', 'operator'])
            ->orderByRaw("
                CASE 
                    WHEN role = 'admin' THEN 1
                    WHEN role = 'operator' THEN 2
                    ELSE 3
                END
            ")
            ->paginate(10);

        return view('admin.pengguna.staff', compact('pengguna'));
    }

    // Menampilkan hanya customer
    public function customer(Request $request)
    {
        $pengguna = Pengguna::where('role', 'customer')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pengguna.customer', compact('pengguna'));
    }


    /**
     * Menampilkan form tambah pengguna operator
     */
    public function create()
    {
        return view('admin.pengguna.create');
    }

    /**
     * Menyimpan pengguna baru
     * Hanya admin yang bisa membuat operator
     */
    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'no_telp' => 'nullable|unique:pengguna,no_telp',
            'password' => 'required|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'password.min' => 'Password tidak boleh kurang dari 6 karakter.',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('pengguna', 'public');
        }

        $validated['password'] = bcrypt($validated['password']);
        $validated['role'] = 'operator'; // hanya bisa buat operator

        // Simpan ke database
        Pengguna::create($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    /**
     * Menampilkan detail pengguna
     */
    public function show(Pengguna $pengguna)
    {
        return view('admin.pengguna.show', compact('pengguna'));
    }

    /**
     * Menampilkan form edit pengguna
     */
    public function edit(Pengguna $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    /**
     * Memperbarui data pengguna
     */
    public function update(Request $request, Pengguna $pengguna)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_pengguna' => 'required|string|max:255',
            'no_telp' => 'nullable|unique:pengguna,no_telp,' . $pengguna->id,
            'password' => 'nullable|min:6',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        /// Cek jika ada foto baru diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
                Storage::disk('public')->delete($pengguna->foto);
            }
            // Upload foto baru
            $validated['foto'] = $request->file('foto')->store('pengguna', 'public');
        }

        // Update password jika diisi
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        // Role tidak boleh diubah (keamanan)
        $validated['role'] = $pengguna->role;

        // Update ke DB
        $pengguna->update($validated);

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil diperbarui');
    }

    /**
     * Menghapus pengguna
     * Admin tidak boleh dihapus
     */
    public function destroy(Pengguna $pengguna)
    {
        // Admin tidak boleh dihapus
        if ($pengguna->role === 'admin') {
            return back()->with('error', 'Admin tidak boleh dihapus.');
        }

        // Hapus foto user jika ada
        if ($pengguna->foto && Storage::disk('public')->exists($pengguna->foto)) {
            Storage::disk('public')->delete($pengguna->foto);
        }

        // Hapus data user
        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}