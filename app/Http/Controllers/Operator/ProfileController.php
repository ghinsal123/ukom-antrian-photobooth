<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Tampilkan halaman edit profile operator
    public function edit()
    {
        $operator = Auth::user(); 
        return view('operator.profile.edit', compact('operator'));
    }

    // Update foto profile operator saja
    public function update(Request $request)
    {
        $request->validate([
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // hanya jpg, jpeg, png
        ]);

        $operator = auth()->user();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('foto_operator', 'public');
            $operator->foto = $path;
            $operator->save();
        }

        return redirect()->route('operator.dashboard')
                        ->with('success', 'Foto profile berhasil diperbarui!');
    }
}
