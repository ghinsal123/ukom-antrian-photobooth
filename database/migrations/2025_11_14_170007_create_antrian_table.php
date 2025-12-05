<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id(); // ID utama

            $table->unsignedBigInteger('pengguna_id'); 
            $table->unsignedBigInteger('booth_id'); 
            $table->unsignedBigInteger('paket_id'); 

            $table->string('nomor_antrian'); 
            $table->date('tanggal'); 
            $table->string('jam', 5)->nullable(); // format HH:MM

            // barcode untuk pemindaian scanner
            $table->string('barcode')->unique();

            // filter waktu mulai dan selesai proses
            $table->timestamp('start_time')->nullable();
            $table->timestamp('foto_start_time')->nullable();
            $table->timestamp('end_time')->nullable();


            $table->unique(['booth_id', 'tanggal', 'nomor_antrian']);

            $table->enum('status', ['menunggu','proses','sesi_foto','selesai','dibatalkan','kadaluarsa'])->default('menunggu');
            $table->text('catatan')->nullable(); 
            $table->timestamps();

            // relasi
            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
            $table->foreign('booth_id')->references('id')->on('booth')->onDelete('cascade');
            $table->foreign('paket_id')->references('id')->on('paket')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrian');
    }
};
