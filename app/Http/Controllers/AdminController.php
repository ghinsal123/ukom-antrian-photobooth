<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Data statistik dashboard
        $cards = [
            ['label' => 'Total Booth', 'value' => 4, 'icon' => 'camera'],
            ['label' => 'Total Paket', 'value' => 6, 'icon' => 'package'],
            ['label' => 'Total Antrian Hari Ini', 'value' => 18, 'icon' => 'users'],
            ['label' => 'Operator Aktif', 'value' => 3, 'icon' => 'user-check'],
        ];

        // Data antrian terbaru (dummy)
        $latest = [
            (object)[
                'customer_name' => 'Ghina Salsabila',
                'package_name' => 'Paket Premium',
                'booth_name' => 'Booth 1',
                'scheduled_at' => '2025-11-13 10:00',
                'status' => 'Selesai',
            ],
            (object)[
                'customer_name' => 'Rafi Pratama',
                'package_name' => 'Paket Hemat',
                'booth_name' => 'Booth 2',
                'scheduled_at' => '2025-11-13 10:30',
                'status' => 'Dipanggil',
            ],
            (object)[
                'customer_name' => 'Lia Amalia',
                'package_name' => 'Paket Regular',
                'booth_name' => 'Booth 3',
                'scheduled_at' => '2025-11-13 11:00',
                'status' => 'Menunggu',
            ],
        ];

        return view('admin.dashboard', compact('cards', 'latest'));
    }
}
