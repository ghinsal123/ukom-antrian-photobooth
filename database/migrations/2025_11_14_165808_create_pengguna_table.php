<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // tabel pengguna
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_pengguna'); 
            $table->string('no_telp')->nullable()->unique(); 
            $table->string('password'); 
            $table->enum('role',['admin','operator','customer']); 
            $table->string('foto')->nullable(); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna'); // hapus tabel 
    }
};
