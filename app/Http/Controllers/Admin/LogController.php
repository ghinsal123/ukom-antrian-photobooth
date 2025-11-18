<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Log;

class LogController extends Controller
{
    public function index()
    {
        $logs = Log::with(['pengguna', 'antrian'])->latest()->paginate(10);
        return view('admin.log.index', compact('logs'));
    }

    public function show($id)
    {
        $log = Log::with(['pengguna', 'antrian'])->findOrFail($id);
        return view('admin.log.show', compact('log'));
    }

    public function destroy($id)
    {
        Log::findOrFail($id)->delete();
        return redirect()->route('admin.log.index')->with('success', 'Log berhasil dihapus');
    }
}
