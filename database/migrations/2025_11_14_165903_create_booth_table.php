<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        //  tabel booth
        Schema::create('booth', function (Blueprint $table) {
            $table->id();
            $table->string('nama_booth');
            $table->integer('kapasitas');
            $table->json('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booth'); // hapus tabel kalo rollback
    }
};
