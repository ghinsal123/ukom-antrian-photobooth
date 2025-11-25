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
        Schema::create('log', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke tabel pengguna
            $table->foreignId('pengguna_id')
                  ->constrained('pengguna')
                  ->onDelete('cascade');
            
            // Foreign key ke tabel antrian, bisa null
            $table->foreignId('antrian_id')
                  ->nullable()
                  ->constrained('antrian')
                  ->onDelete('cascade');
            
            // Enum aksi termasuk update_antrian
            $table->enum('aksi', ['buat_antrian', 'update_status', 'hapus_antrian', 'update_antrian'])
                  ->default('buat_antrian');
            
            // Keterangan log bisa null
            $table->text('keterangan')->nullable();
            
            // Timestamp created_at & updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log');
    }
};
