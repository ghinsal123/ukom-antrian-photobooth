<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('antrian', function (Blueprint $table) {

            // menambahkan kolom barcode
            if (!Schema::hasColumn('antrian', 'barcode')) {
                $table->string('barcode')->unique()->nullable()->after('nomor_antrian');
            }

            // menambahkan kolom scan_at 
            if (!Schema::hasColumn('antrian', 'scan_at')) {
                $table->timestamp('scan_at')->nullable()->after('barcode');
            }

            // menambahkan kolom expired_at
            if (!Schema::hasColumn('antrian', 'expired_at')) {
                $table->timestamp('expired_at')->nullable()->after('scan_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antrian', function (Blueprint $table) {
            //
        });
    }
};
